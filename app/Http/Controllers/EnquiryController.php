<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Enquiry;
use App\Mail\EnquiryMail;
use App\Mail\EnquiryReplyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //$this->authorize('viewAny', Enquiry::class);

        if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
        {
            $enquiries = Enquiry::with(['children'])->where('parent_id',NULL)->paginate(Config::get('settings.pagination'));
        } else {
            $enquiries = Enquiry::with(['children'])->where('created_id', Auth::id())
                ->paginate(Config::get('settings.pagination'));
        }

        return $this->processResponse('enquiries', $enquiries,null,'success', 200);
    }
    public function mark_read_at(Request $request)
    {
        //$this->authorize('viewAny', Enquiry::class);
        $enquiry = Enquiry::find($request->input('enquiry_id'));
        $enquiry->read_at = Carbon::now();
        $enquiry->save();

        return $this->processResponse('enquiries_mark_reat_at', null,null,'success', 200);
    }


    public function reply(Request $request)
    {
        DB::beginTransaction();

        $enquiry = new Enquiry;
        $enquiry->name          =  Auth::user()->name;
        $enquiry->email         = Auth::user()->email;
        $enquiry->mobile        = Auth::user()->mobile;
        $enquiry->subject       = 'Enquiry reply!!';
        $enquiry->description   = $request->input('reply');
        $enquiry->parent_id     =  $request->input('parent_id');
        $enquiry->created_id    =  Auth::user()->id;
        $enquiry->read_at       =  Carbon::now();
        $enquiry->save();

        Mail::to($request->input('email'))->bcc('asklko2004@gmail.com')
            ->send(new EnquiryReplyMail(
                'gauu1001@gmail.com',
                $request->input('enquiry_user_name'),
                7905183841,
                $request->input('reply'),
            ));

        DB::commit();

        return $this->processResponse('data',null,'Enquiry reply stored && mail sent!!','success',200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $enquiry = new Enquiry;
        $enquiry->name          =  $request->input('name');
        $enquiry->email         =  $request->input('email');
        $enquiry->mobile        = $request->input('number');
        $enquiry->subject       = 'Contact me!!';
        $enquiry->description   = 'Contact me!!';
        $enquiry->save();

        Mail::to('gauu1001@gmail.com')->bcc('asklko2004@gmail.com')
            ->send(new EnquiryMail(
                $request->input('email'),
                $request->input('name'),
                $request->input('number')
            ));

        DB::commit();

        return $this->processResponse('data',null,'Enquiry stored & Mail Sent!!','success',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function show(Enquiry $enquiry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function edit(Enquiry $enquiry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enquiry $enquiry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enquiry $enquiry)
    {
        //$this->authorize('delete', $blog);
        foreach($enquiry->children as $child){
            $child->delete();
        }

        $enquiry->delete();

        return $this->processResponse('data', null, 'Enquiry deleted successfully!', 'success', 200);
    }
}
