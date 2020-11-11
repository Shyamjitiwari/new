<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Lead;
use App\Mail\NewLead;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class RoofFloorController extends Controller
{
    protected $key = '_01Roof&Floor@';

    public function postLeadProcess(Request $request)
    {
//        return $request->input();

        if($request->has('api_key') && $request->api_key == Config::get('settings.roof-floor.key'))
        {
            $request->validate([
                'api_key' => 'required',
                'RESPONDER-NAME' => 'required',
                'RESPONDER-EMAIL' => 'required|email',
                'RESPONDER_PHONE' => 'required',
            ]);

            $parentPresent = Helper::searchParentLead($request->input('RESPONDER_PHONE'));

            $lead = Lead::create(
                [
                    'parent_id' => $parentPresent ? $parentPresent->id : null,
                    'name' => $request->input('RESPONDER-NAME'),
                    'email' => $request->input('RESPONDER-EMAIL'),
                    'mobile' => $request->input('RESPONDER_PHONE'),
                    'remarks' => json_encode($request->input()),
                    'lead_source_id' => 8, // id for RoofFloor source
                    'lead_status_id' => 12, // id for sub status Un Assigned
                    'created_id' => $parentPresent ? $parentPresent->created_id : Helper::assignLeadOnRoundRobinBasis($request->input('RESPONDER_PHONE')),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );

            //dispatch new lead intimation mail
            $user = User::find($lead->created_id);
            Mail::to($user->email)->send(new NewLead($user, $lead));

            return $this->processResponse('success', '200', 'Lead added!');
        } else {
            return $this->processResponse('error', '404', 'Invalid api key');
        }
    }

    public function getLeadProcess(Request $request)
    {

        if($request->has('api_key') && $request->api_key == Config::get('settings.roof-floor.key'))
        {
            $request->validate([
                'api_key' => 'required',
                'RESPONDER-NAME' => 'required',
                'RESPONDER-EMAIL' => 'required|email',
                'RESPONDER_PHONE' => 'required',
            ]);

            $parentPresent = Helper::searchParentLead($request->input('RESPONDER_PHONE'));

            $lead = Lead::create(
                [
                    'parent_id' => $parentPresent ? $parentPresent->id : null,
                    'name' => $request->input('RESPONDER-NAME'),
                    'email' => $request->input('RESPONDER-EMAIL'),
                    'mobile' => $request->input('RESPONDER_PHONE'),
                    'remarks' => json_encode($request->input()),
                    'lead_source_id' => 8, // id for RoofFloor source
                    'lead_status_id' => 12, // id for sub status Un Assigned
                    'created_id' => $parentPresent ? $parentPresent->created_id : Helper::assignLeadOnRoundRobinBasis($request->input('RESPONDER_PHONE')),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );

            //dispatch new lead intimation mail
            $user = User::find($lead->created_id);
            Mail::to($user->email)->send(new NewLead($user, $lead));

            return $this->processResponse('success', '200', 'Lead added!');
        } else {
            return $this->processResponse('error', '404', 'Invalid api key');
        }
    }


}



