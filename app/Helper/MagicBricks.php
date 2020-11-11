<?php


namespace App\Helper;


use App\Lead;
use App\Api;
use App\Mail\NewLead;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MagicBricks
{
    public static function processLeads()
    {
        MagicBricks::makeRequestXML();

        $newLeads = \App\MagicBricks::where('status', 'new')->get();

        //delete all leads older than yesterday
        //\App\MagicBricks::whereDate('created_at', '<', Carbon::now()->subDays(1))->delete();

        if($newLeads->count()) {
            foreach ($newLeads as $lead) {
                MagicBricks::createAndAssignLeads($lead->id);
            }
        }

    }

    public static function getLeads($allParams,$url)
    {
        // Get cURL resource
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url.$allParams,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request'
        ]);
        return curl_exec($curl);
    }

    public static function makeRequestXML()
    {
        //get time of last lead imported for this type of api user account
//        $lastLeadImportTime = (\App\MagicBricks::all()->count())
//            ? \App\Acre::orderBy('received_at', 'desc')->first()->received_at
//            : null;

        $start_date = Carbon::now()->subDays(5)->format('Ymd');

        $end_date = Carbon::now()->format('Ymd');

        foreach(Api::where('type','magic_bricks')->where('status','active')->whereHas('user_group')->get() as $magic_brick_api){

            // $url =  Config::get('settings.magic_bricks.url');
            // $key =  Config::get('settings.magic_bricks.key');
            // $params = '?key='.$key."&startDate=".$start_date."&endDate=".$end_date;

             $url =     $magic_brick_api->url;
             $key =     $magic_brick_api->key;
             $params = '?key='.$key."&startDate=".$start_date."&endDate=".$end_date;

            $leads = MagicBricks::getLeads($params,$url);
            MagicBricks::processResponseXML($leads,  $magic_brick_api->id);
        }
       
    }

    public static function processResponseXML($leads, $api_id)
    {
        $transformed = (xml_to_array($leads));

        Storage::put('magic_bricks.json', json_encode($transformed));
        $leads = json_decode(Storage::get('magic_bricks.json'));
        Storage::delete('magic_bricks.json');
        
        foreach($leads->leads->lead as $t)
        {
            $isDuplicate = \App\MagicBricks::where(
                [
                    'mb_id'=>$t->id ? $t->id : null,
                    'phone'=> $t->mobile,
                    'project_name'=> $t->project ? $t->project : null,
                ])->count();

            if(!$isDuplicate) {
                \App\MagicBricks::create([
                    'mb_id'=>$t->id ? $t->id : null,
                    'api_id'=>$api_id,
                    'received_at' => $t->dt ? $t->dt : null,
                    'name'=>$t->name ? $t->name : null,
                    'status' => 'new',
                    'email'=>$t->email ? $t->email : null,
                    'phone'=> $t->mobile,
                    'project_name'=> $t->project ? $t->project : null,
                    'project_details' => $t->locality ? $t->locality : null,
                    'query_info' => $t->msg ? $t->msg : null,
                    'payload' => json_encode($t),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }

    public static function createAndAssignLeads($id)
    {
        $magic_brick = \App\MagicBricks::find($id);

        if($magic_brick)
        {
            //check if parent of this lead is present, => assign this lead to that parent
            $parentPresent = Helper::searchParentLead($magic_brick->phone);

            if(!$parentPresent){

                DB::beginTransaction();
            // save a new lead in leads table
            $lead = Lead::create(
                [
                    'parent_id' => $parentPresent ? $parentPresent->id : null,
                    'name' => $magic_brick->name,
                    'email' => $magic_brick->email,
                    'mobile' => $magic_brick->phone,
                    'project' => $magic_brick->project_name,
                    'remarks' => $magic_brick->query_info,
                    'lead_source_id' => 1, // id for magic bricks source
                    'lead_status_id' => 12, // id for sub status Un Assigned
                    'created_id' =>  $parentPresent ? $parentPresent->created_id : Helper::assignLeadOnRoundRobinBasis($magic_brick->phone, $magic_brick->api->user_group_id),
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
            $magic_brick->status = 'old';
            $magic_brick->save();
            DB::commit();

            //dispatch new lead intimation mail
            $user = User::find($lead->created_id);
           // Mail::to($user->email)->send(new NewLead($user, $lead));
            }
            
        }

    }

}
