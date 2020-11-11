<?php

namespace App\Http\Controllers;

use App\Lead;
use App\Traits\Common;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function leads()
    {
        return view('admin.leads.leads');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $name = ($request->input('name')) ? $request->input('name') : '';
        $phone = ($request->input('phone')) ? $request->input('phone') : '';
        $email = ($request->input('email')) ? $request->input('email') : '';
        $lead_source = ($request->input('lead_source')) ? $request->input('lead_source') : '';
        $lead_status = ($request->input('lead_status')) ? $request->input('lead_status') : '';

        $leads = Lead::where('is_deleted', 0)
            ->search('name', $name)
            ->search('phone_number', $phone)
            ->search('email', $email)
            ->searchMany('name', $lead_source,'lead_source')
            ->searchMany('name', $lead_status,'lead_status')
            ->with(['lead_source','lead_status', 'tags'])
            ->where('is_deleted', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json(['data'=> $leads, 'message' => null, 'status'=>'success'],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        if(!$request->input('id'))
        {
            $message = 'Lead created';
        } else {
            $message = 'Lead updated';
        }

        DB::beginTransaction();

        $lead = Lead::updateOrcreate(
            ['id' => $request->input('id')],
            [
                'name' => $request->input('name'),
                'phone_number' => $request->input('phone_number'),
                'email' => $request->input('email'),
                'lead_source_id' => $request->input('lead_source_id'),
                'lead_status_id' => $request->input('lead_status_id'),
                'description' => $request->input('description'),
                'free_session_date' => $request->input('free_session_date'),
                !$request->input('id') ? 'created_id' : 'updated_id'  =>  Auth::user()->id,
            ]
        );

        if($request->input('tags'))
        {
            $lead->tags()->detach();

            foreach($request->input('tags') as $tag)
            {
                $lead->tags()->attach($tag['id']);
            }
        } else {
            $lead->tags()->detach();
        }

        DB::commit();


        return response()->json(['data'=> $lead, 'message' => $message, 'status'=>'success'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lead  $lead
     * @return Response
     */
    public function show(Lead $lead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lead  $lead
     * @return Response
     */
    public function edit(Lead $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lead  $lead
     * @return Response
     */
    public function update(Request $request, Lead $lead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lead  $lead
     * @return Response
     */
    public function destroy(Lead $lead)
    {
        //
    }
}
