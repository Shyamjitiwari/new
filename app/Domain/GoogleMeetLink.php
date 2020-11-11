<?php

namespace App\Domain;
use Illuminate\Support\Facades\Session;
use App\Domain\GoogleCalendarApi;

class GoogleMeetLink{

    public function generateGoogleMeetLink($userName){
        $studentname = $userName;
        $event['title'] = "Coding Class for ".$studentname." at Code With Us";
        $event['description'] = "To start the coding class for ".$studentname.", simply click on the Google Meet link in this invite and wait for the teacher to arrive. We are beta-testing this new system. If the teacher is not there, please contact us by going to codewithus.com and starting a chat at the bottom right of the screen or by calling (408)909-7717. ";
        $event['all_day'] = 0;
        $event['event_time']['start_time'] = "2020-04-04T09:00:00";
        $event['event_time']['end_time'] = "2020-04-04T10:00:00";
        $event['invitee'] = "avesta@codewithus.com";

        $_SESSION['refresh_token'] = "1//06PeD3gJK0hwuCgYIARAAGAYSNwF-L9IrcbtnPDLMI-D_bTitPuqu31ETPGDJ-ABNV3BnvMbMrkWG4fg8YjkbDO7ViNBEx0LxXG4";
	    $capi = new GoogleCalendarApi();
	    $data = $capi->GetRefreshedAccessToken(env('CLIENT_ID'), env('REFRESH_TOKEN'), env('CLIENT_SECRET'));
	    $access_token = $data['access_token'];
        //echo $access_token;
        

        $_SESSION['user_timezone'] = $capi->GetUserCalendarTimezone($access_token);
		$event_id = $capi->CreateCalendarEvent('primary', $event['title'], $event['description'], $event['all_day'], $event['event_time'], $_SESSION['user_timezone'], $access_token, $event['invitee']);
		$eventData = $event_id['conferenceData']['conferenceId'];
        $hangoutLink = $event_id['hangoutLink']; 
        return $hangoutLink;
    }
}