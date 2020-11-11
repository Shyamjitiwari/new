<?php


namespace App\Helper;


use App\Lead;
use App\Api;
use App\Mail\NewLead;
use App\User;
use App\LeadHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class Acre
{
    public static function processAcreLeads()
    {
        Acre::makeRequestXML();

        $newAcreLeads = \App\Acre::where('status', 'new')->get();

        //delete all leads older than yesterday
        \App\Acre::whereDate('created_at', '<', Carbon::now()->subDays(1))->delete();

        foreach($newAcreLeads as $lead)
        {
            Acre::createAndAssignLeads($lead->id);
        }

    }

    public static function get99AcresLeads($allParams,$url)
    {
        $crl = curl_init($url);
        curl_setopt ($crl, CURLOPT_POST, 1);
        curl_setopt ($crl, CURLOPT_POSTFIELDS, $allParams);
        curl_setopt ($crl, CURLOPT_RETURNTRANSFER,1);
        return curl_exec ($crl);
    }

    public static function makeRequestXML()
    {
        //get time of last lead imported for this type of api user account
        $lastLeadImportTime = (\App\Acre::all()->count())
            ? \App\Acre::orderBy('received_at', 'desc')->first()->received_at
            : null;

        // $start_date = $lastLeadImportTime ? $lastLeadImportTime : Carbon::now()->today()->toDateTimeString();
        $start_date = Carbon::now()->subDays(2)->toDateTimeString();

        $end_date = Carbon::now()->toDateTimeString();

        foreach(Api::where('type','acers')->whereHas('user_group')->where('status','active')->get() as $acer_api){
           dd($acer_api);
            // $url =  "http://www.99acres.com/99api/v1/getmy99Response/OeAuXClO43hwseaXEQ/uid/";
            $request = "<?xml version='1.0'?><query><user_name>".Config::get('settings.acres.user_name')."</user_name><pswd>".Config::get('settings.acres.password')."</pswd><start_date>".$start_date."</start_date><end_date>".$end_date."</end_date></query>";
           
            $url = $acer_api->url;
            $request =  "<?xml version='1.0'?><query><user_name>".$acer_api->user_name."</user_name><pswd>".$acer_api->password."</pswd><start_date>".$start_date."</start_date><end_date>".$end_date."</end_date></query>";
           
            $allParams = array('xml'=>$request);
           
            $leads = Acre::get99AcresLeads($allParams,$url);
            dd($leads);
            Acre::processResponseXML($leads, $acer_api->id);
        }
        
    }

    public static function processResponseXML($leads , $api_id)
    {
        $transformed = (xml_to_array($leads));

        Storage::put('acre.json', json_encode($transformed));
        $leads = json_decode(Storage::get('acre.json'));
        //Storage::delete('acre.json');
        foreach($leads->Resp as $t)
        {
            $isDuplicate = \App\Acre::where(
                [
                    'name'=>$t->QryDtl->RcvdOn ? $t->QryDtl->RcvdOn : null,
                    'email'=>$t->CntctDtl->Email ? $t->CntctDtl->Email : null,
                    'phone'=> explode('-', $t->CntctDtl->Phone)[1],
                    'project_name'=> $t->QryDtl->ProjName ? $t->QryDtl->ProjName : null,
                    'project_id'=> $t->QryDtl->ProjId ? $t->QryDtl->ProjId : null,
                ])->count();

            if(!$isDuplicate) {
                \App\Acre::create([
                    'received_at' => $t->QryDtl->RcvdOn ? $t->QryDtl->RcvdOn : null,
                    'name' => $t->CntctDtl->Name ? $t->CntctDtl->Name : null,
                    'aip_id' => $api_id,
                    'status' => 'new',
                    'email' => $t->CntctDtl->Email ? $t->CntctDtl->Email : null,
                    'phone' => $t->CntctDtl->Phone ? explode('-', $t->CntctDtl->Phone)[1] : null,
                    'project_name' => $t->QryDtl->ProjName ? $t->QryDtl->ProjName : null,
                    'project_id' => $t->QryDtl->ProjId ? $t->QryDtl->ProjId : null,
                    'project_details' => $t->QryDtl->CmpctLabl ? $t->QryDtl->CmpctLabl : null,
                    'query_info' => $t->QryDtl->QryInfo ? $t->QryDtl->QryInfo : null,
                    'phone_verification_status' => $t->QryDtl->PhoneVerificationStatus ? $t->QryDtl->PhoneVerificationStatus : null,
                    'email_verification_status' => $t->QryDtl->EmailVerificationStatus ? $t->QryDtl->EmailVerificationStatus : null,
                    'identity' => $t->QryDtl->IDENTITY ? $t->QryDtl->IDENTITY : null,
                    'property_code' => $t->QryDtl->PROPERTY_CODE ? $t->QryDtl->PROPERTY_CODE : null,
                    'sub_user_name' => $t->QryDtl->SubUserName ? $t->QryDtl->SubUserName : null,
                    'payload' => json_encode($t),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }

    public static function createAndAssignLeads($id)
    {
        $acre = \App\Acre::find($id);

        if($acre && Helper::isValidLead($acre->phone,2))
        {
            //check if parent of this lead is present, => assign this lead to that parent
            $parentPresent = Helper::searchParentLead($acre->phone);

            if(!$parentPresent){
                DB::beginTransaction();
                // save a new lead in leads table
                $lead = Lead::create(
                    [
                        'parent_id' => $parentPresent ? $parentPresent->id : null,
                        'name' => $acre->name,
                        'email' => $acre->email,
                        'mobile' => $acre->phone,
                        'project' => $acre->project_name,
                        'remarks' => $acre->payload,
                        'lead_source_id' => 2, // id for 99acres source
                        'lead_status_id' => 12, // id for sub status Un Assigned
                        'created_id' =>  $parentPresent ? $parentPresent->created_id : Helper::assignLeadOnRoundRobinBasis($acre->phone, $acre->api->user_group_id),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]
                );
    
                if($parentPresent){
                    LeadHistory::markPreviousFollowupAsCompleted($lead->id);
                    LeadHistory::updateFollowUpAtInLeads($lead->id, Carbon::now());
    
                    LeadHistory::create(
                        [
                           'lead_id' => $lead->id,
                           'historical_id' => null,
                           'historical_type' =>  null,
                           'remarks' => null,
                           'follow_up_at' => Carbon::now()->toDateTimeString(),
                           'created_id' => 1
                        ]
                    );
            
                }
    
                $acre->status = 'old';
                $acre->save();
                DB::commit();
    
                //dispatch new lead intimation mail
                $user = User::find($lead->created_id);
                Mail::to($user->email)->send(new NewLead($user, $lead));
            }

          

        }

    }

}
