<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Reference;
use App\Helper\Helper;
use App\Domain\MailFunctions;
use App\Country;
use App\User;

class ReferenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|parent');
    }

    public function referenceForm(){
        return view('parent.send_reference_form');
    }

    public function addAndSendReference(Request $request){
        $user = Auth::user();
        $emailId = $request->email;
        $countryId = $request->country_id;
        $phoneNumber = $request->phone_number;

        $hashCodeString = $user->id.$emailId.$phoneNumber;
        $hashCode = Hash::make($hashCodeString);
        $hashcodeAlreadyExists = Reference::where(['email' => $emailId,
                                                   'phone_number' => $phoneNumber ,
                                                   'referred_by' => $user->id])->value('reference_hash');

        if($hashcodeAlreadyExists == null || $hashcodeAlreadyExists == ""){
            Reference::updateOrCreate([
                'reference_hash' => $hashCode,
                'email' => $emailId,
                'country_id' => $countryId,
                'phone_number' => $phoneNumber,
                'referred_by' => $user->id,
            ]);
        }else{
            $hashCode = $hashcodeAlreadyExists;
        }

        $countryCodeForReferredPerson = Country::where('id',$request->country_id)->value('calling_code');
        $phoneNumberWithCountryCallingCodeOfReferredPerson = $countryCodeForReferredPerson.$request->phone_number;
        
        $countryCodeForReferree = Country::where('id',$user->country_id)->value('calling_code');
        $phoneNumberWithCountryCallingCodeOfReferree = $countryCodeForReferree.$user->phone_number;

        $data = [
                'hashed_reference' => $hashCode,
                'email' => $emailId,
                'country_id' => $countryId,
                'referred_by_phone' => $phoneNumberWithCountryCallingCodeOfReferree,
                'referred_by' => $user->id,
        ];        
        $smsMessage = __('sms_and_email.reference_text_message', ['PhoneNumber' => $phoneNumberWithCountryCallingCodeOfReferree]);

        MailFunctions::send_reference_email($emailId,$data);
        Helper::sendSMS($smsMessage,$phoneNumberWithCountryCallingCodeOfReferredPerson);       
        
        return response()->json(['message'=> 'Reference has been sent.'],200);
    }

}
