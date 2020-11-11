<?php

namespace App\Helper;

use App\Activity;
use App\Lead;
use App\Api;
use App\Mail\NewLead;
use App\User;
use App\Housing;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class Helper {

    public static function getHashHmac($id, $start_date, $end_date, $api)
    {
        $current_timestamp = (new \Carbon\Carbon)->timestamp;
        return [
            'current_timestamp' => $current_timestamp,
            'id' => $api->account_id,
            'hash' => hash_hmac('sha256', $current_timestamp, $api->key),
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];

    }

    public static function processHousingLeads($id)
    {
        Helper::getHousingLeads($id);

        $newHousingLeads = Housing::where('status', 'new')->get();

        //delete all leads older than yesterday
        Housing::whereDate('created_at', '<', Carbon::now()->subDays(1))->delete();

        foreach($newHousingLeads as $lead)
        {
            Helper::createAndAssignLeads($lead->id);
        }

    }

    public static function getHousingLeads($id, $start_date = null, $end_date = null)
    {
        $client = new \GuzzleHttp\Client();

         // $start_date = $lastLeadImportTime ? $lastLeadImportTime : Carbon::now()->today()->timestamp;
         $start_date =  Carbon::now()->startOfWeek()->timestamp;

         $end_date = Carbon::now()->timestamp;
 

        foreach(Api::where('type','housing')->where('status','active')->whereHas('user_group')->get() as $housing_api){
           
               //get time of last lead imported for this type of api user account
            // $lastLeadImportTime = (Housing::where('type', $id)->get()->count())
            // ? Housing::where('type', $id)->orderBy('id', 'desc')->first()->lead_date
            // : null;

           //get time of last lead imported for this type of api user account
           $lastLeadImportTime = (Housing::where('type', $id)->where('api_id',$housing_api->id)->get()->count())
           ? Housing::where('type', $id)->orderBy('id', 'desc')->first()->lead_date
           : null;

           $formParams = Helper::getHashHmac($id, $start_date, $end_date, $housing_api);

           
        // Sending an asynchronous request.
        // $request = new \GuzzleHttp\Psr7\Request('GET', Config::get('housing_url'),$formParams);
       
        // $request = new \GuzzleHttp\Psr7\Request('GET',Config::get('settings.housing.housing_url').
        // "?id=".$formParams['id']."&hash=".$formParams['hash']."&start_date=".
        // $formParams['start_date']."&end_date=".$formParams['end_date']."&current_time=".
        // $formParams['current_timestamp']);
        
        $request = new \GuzzleHttp\Psr7\Request('GET',$housing_api->url.
        "?id=".$formParams['id']."&hash=".$formParams['hash']."&start_date=".
        $formParams['start_date']."&end_date=".$formParams['end_date']."&current_time=".
        $formParams['current_timestamp']);

        
        $promise = $client->sendAsync($request)->then(function ($response) use($id, $lastLeadImportTime, $housing_api)
        {
         
            Storage::put('leads.json', $response->getBody());
            $leads = json_decode(Storage::get('leads.json'));
            //Storage::delete('leads.json');
         
            if($response->getBody()){
                 foreach($leads as $lead){

                     $isDuplicate = Housing::where(
                         [
                             'lead_name' => property_exists($lead, 'lead_name') || $lead->lead_name != null ? $lead->lead_name : 'No name present',
                             'lead_email' => property_exists($lead, 'lead_email') || $lead->lead_email != null ? $lead->lead_email : 'no-email@present.com',
                             'lead_phone' => property_exists($lead, 'lead_phone') || $lead->lead_phone != null ? $lead->lead_phone : 'No phone or mobile present',
                             'project_name'=>$lead->project_name
                         ])->count();
                        
                    if($lead->lead_date > $lastLeadImportTime && !$isDuplicate) {
                        Housing::create(
                            [
                                'type' => $id,
                                'api_id' => $housing_api->id,
                                'lead_date' => $lead->lead_date,
                                'apartment_names' => $lead->apartment_names,
                                'country_code' => $lead->country_code,
                                'service_type' => $lead->service_type,
                                'category_type' => $lead->category_type,
                                'locality_name' => $lead->locality_name,
                                'city_name' => $lead->city_name,
                                'lead_name' => Arr::exists($lead, 'lead_name') || $lead->lead_name != null ? $lead->lead_name : 'No name present',
                                'lead_email' => Arr::exists($lead, 'lead_email') || $lead->lead_email != null ? $lead->lead_email : 'no-email@present.com',
                                'lead_phone' => Arr::exists($lead, 'lead_phone') || $lead->lead_phone != null ? $lead->lead_phone : 'No phone or mobile present',
                                'project_name' => $lead->project_name,
                                'payload' => json_encode($lead),
                                'status' => 'new'
                            ]
                        );
                    }
                 }
             }

        });

        $promise->wait();

        }   
        
    }

    public static function createAndAssignLeads($id)
    {
        $housing = Housing::find($id);
       
        if($housing) // && Helper::isValidLead($housing->lead_phone,3)  for now we r not allowing dulicate lead so lead is already valid
        {
            //check if parent of this lead is present, => assign this lead to that parent
            $parentPresent = Helper::searchParentLead($housing->lead_phone);

            if(!$parentPresent){

                DB::beginTransaction();
                // save a new lead in leads table
                $lead = Lead::create(
                    [
                        'parent_id' => $parentPresent ? $parentPresent->id : null,
                        'name' => $housing->lead_name,
                        'email' => $housing->lead_email,
                        'mobile' => $housing->lead_phone,
                        'project' => $housing->project_name,
                        'project_type' => $housing->apartment_names,
                        'remarks' => $housing->payload,
                        'lead_source_id' => 3, // id for housing source
                        'lead_status_id' => 12, // id for sub status Un Assigned
                        'created_id' =>  $parentPresent ? $parentPresent->created_id : Helper::assignLeadOnRoundRobinBasis($housing->lead_phone, $housing->api->user_group_id),
                        'created_at' => Carbon::createFromTimestamp($housing->lead_date),
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
                
                $housing->status = 'old';
                $housing->save();
                DB::commit();
    
                //dispatch new lead intimation mail
                $user = User::find($lead->created_id);
                Mail::to($user->email)->send(new NewLead($user, $lead));
            }
          
        }
    }

    public static function similarLeadExists($lead_phone)
    {
        // logic to check if this mobile number in this new leads has been assigned to any user previously,
        // if yes then return user_id else null
        return Lead::search('mobile', $lead_phone)->orderBy('created_at', 'desc')->first()
        ? Lead::search('mobile', $lead_phone)->orderBy('created_at', 'desc')->first()->created_id
        : null;
    }

    public static function searchParentLead($lead_phone)
    {
        $lead = Lead::where(['mobile'=> $lead_phone, 'parent_id' => null])->first();
        return $lead ? $lead : null;
    }

    public static function assignLeadOnRoundRobinBasis($api_lead_phone, $group_id)
    {
       // $teleSalesUsers = User::where('role_id', 3)->where('status', 'active')->pluck('id');

       $teleSalesUsersUnchecked = User::where('status', 'active')->where('user_group_id',$group_id)->get();
       $teleSalesUsers = array();
       foreach($teleSalesUsersUnchecked as $teleSalesUserUnchecked){

            if(!$teleSalesUserUnchecked->isAbsentForToday()){
                $teleSalesUsers[] = $teleSalesUserUnchecked->id;
            }
       }
      $teleSalesUsers = collect($teleSalesUsers);
      if($teleSalesUsers->count()){

        $lastLeadAssignedUser = (Lead::all()->count())
        ? Lead::whereIn('created_id', $teleSalesUsers)->orderBy('id', 'desc')->first()->created_id
        : null;

        // if no leads are assigned i.e. last assigned user is null
        if(!$lastLeadAssignedUser)
        {
            //Take the first telesales user
            $assignToUserId = $teleSalesUsers[0];

        } else {

            //geting the id of the telesales person to whom the last lead is assigned
            $positionOflasLeadAssignedUser = $teleSalesUsers->search($lastLeadAssignedUser);

            //check if position is last
            if ($positionOflasLeadAssignedUser == ($teleSalesUsers->count()) - 1) {
                // if last then take the first telesales user
                $assignToUserId = $teleSalesUsers[0];
            } else {
                // else get the next user in line
                $assignToUserId = $teleSalesUsers->only($teleSalesUsers
                ->search($lastLeadAssignedUser) + 1)[$teleSalesUsers->search($lastLeadAssignedUser) + 1];
            }
        }

        return $assignToUserId;
      }
      else{
          return null;
      }
       
    }

    public static function getLoggedInUsers()
    {
        return User::whereHas('tokens', function($query){$query->where('revoked', 0);})->get();
    }

    public static function isUserInactive($user)
    {
        $last = Activity::whereHasMorph( 'activity', 'App\User', function (Builder $query) use($user) {
            $query->where('id',  $user->id);})
            ->orderBy('created_at', 'desc')
            ->first();

        $now = Carbon::now();
        $lastActivity = Carbon::parse($last->created_at)->addMinutes(
            (int) DB::table('settings')->where('key', 'auto_logout')->first()->value
        );

        return $lastActivity < $now;
    }

    public static function revokeToken($user)
    {
        foreach($user->tokens as $token)
        {
            $token->revoke();
        }
    }

    public static function updateChildLeadsStatus($lead_id, $lead_status_id)
    {
        $lead = Lead::where('id', $lead_id)->with('children')->first();

        foreach ($lead->children as $child) {
            if ($child->lead_status_id != $lead_status_id) {
                $child->lead_status_id = $lead_status_id;
                $child->save();
            }
        }
    }

    public static function isLeadDuplicate($lead)
    {
        return Lead::where('name', $lead->name)
            ->where('email', property_exists($lead,'email')  ? $lead->email : null)
            ->where('mobile', $lead->number)
            ->where('project', property_exists($lead,'project')  ? $lead->project : null)
            ->first();
    }

//    // generate a request url to housing for testing purposes in rest client / postman
//    public static function getHashHmacUrl($id, $start_date, $end_date)
//    {
//        $formParams = Helper::getHashHmac($id, $start_date, $end_date);
//
//        return Config::get('settings.housing.housing_url').
//            "?id=".$formParams['id']."&hash=".$formParams['hash']."&start_date=".
//            $formParams['start_date']."&end_date=".$formParams['end_date']."&current_time=".
//            $formParams['current_timestamp'];
//    }

    public static function isValidLead($phone, $source_id){

        $isNotValid = Lead::where(['mobile'=>$phone, 'lead_souurce_id'=>$source_id])
        ->where(Carbon::parse('created_at')->diffInDays(Carbon::now()), '<',1)
        ->count();
         return $isNotValid  ? false : true; 
    }
}
