<?php

namespace App\Http\Controllers;

use App\Mail\EnquiryMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEnquiryEmail(Request $request)
    {
        DB::table('enquiries')->insert([
            'name'      =>  $request->input('name'),
            'email'     =>  $request->input('email'),
            'mobile'    => $request->input('number')
        ]);
        
        Mail::to('gauu1001@gmail.com')->bcc('asklko2004@gmail.com')
            ->send(new EnquiryMail(
                $request->input('email'),
                $request->input('name'),
                $request->input('number')
            ));
        return $this->processResponse('data',null,'Mail Send','success',200);
    }
}
