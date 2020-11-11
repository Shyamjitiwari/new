<?php

namespace App\Http\Controllers;

use App\Constants\ActivityLabels;
use App\Helper\Helper;
use App\Helper\LogActivity;
use App\Lead;
use Carbon\Carbon;
use App\LeadHistory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LeadHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Lead::class);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Lead::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Lead::class);

        if(!$request->has('snooze')) {
            $request->validate([
                'lead_id' => 'required',
                'lead_status_id' => 'required',
                'remarks' => 'required',
            ]);
        } else {
            $request->validate([
                'follow_up_at' => 'required',
            ]);
        }

        DB::beginTransaction();

        if($request->input('follow_up_at'))
        {
            // mark previous follow up at as completed
            $this->markPreviousFollowupAsCompleted($request->input('lead_id'));
            // update follow at in leads table
            $this->updateFollowUpAtInLeads($request->input('lead_id'), $request->input('follow_up_at'));
        }

        LeadHistory::create(
            [
               'lead_id' => $request->input('lead_id'),
               'historical_id' => $request->input('lead_status_id') ? $request->input('lead_status_id') : null,
               'historical_type' => $request->input('lead_status_id') ? 'App\LeadStatus' : null,
               'remarks' => $request->input('remarks'),
               'follow_up_at' => ($request->input('follow_up_at')) ? $request->input('follow_up_at') : null,
               'created_id' => Auth::user()->id
            ]
        );

        if(!$request->has('snooze'))
        {
            Lead::find($request->input('lead_id'))->update([
                'lead_status_id' => $request->input('lead_status_id'),
            ]);

            Helper::updateChildLeadsStatus($request->input('lead_id'),$request->input('lead_status_id'));
            $message = 'Lead Status updated!';
        } else {
            $message = 'Followup updated!';
        }

        DB::commit();

        if($request->has('snooze'))
        {
            LogActivity::add(Auth::user(), 'ActivityLabels::_LEAD_SNOOZED');
        } else {
            LogActivity::add(Auth::user(), 'ActivityLabels::_LEAD_STATUS_UPDATED');
        }

        return $this->processResponse('success', 200, $message, null);
    }

    public static function updateFollowUpAtInLeads($lead_id, $follow_up_at)
    {
        Lead::where('id', $lead_id)
            ->update([
                'follow_up_at' => $follow_up_at
            ]);
    }

    public static function markPreviousFollowupAsCompleted($lead_id)
    {
        LeadHistory::where('lead_id', $lead_id)
            ->where('follow_up_at', '!=', null)
            ->where('completed', false)
            ->update([
                'completed' => true
            ]);
    }

    public function storeProjectHistory(Request $request)
    {

        $this->authorize('create', Lead::class);

        $projects = $request->input('projects');

        $request->validate([
            'lead_id' => 'required',
            'projects' => 'required',
            'remarks' => 'required',
        ]);

        DB::beginTransaction();

        $this->markProjectNotInterested($request->input('lead_id'));

        $history = LeadHistory::create(
            [
                'lead_id' => $request->input('lead_id'),
                'remarks' => $request->input('remarks'),
                'created_id' => Auth::user()->id
            ]
        );

        $history->projects()->attach(collect($request->input('projects'))->pluck('id'));

        DB::commit();

        LogActivity::add(Auth::user(), 'ActivityLabels::_LEAD_PROJECT_UPDATED');

        return $this->processResponse('success', 200, 'Interested projects updated', null);
    }

    public function markProjectNotInterested($lead_id)
    {
        LeadHistory::where(['lead_id'=> $lead_id,'follow_up_at' => null,'completed'=> 0])->update(['completed' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param LeadHistory $leadHistory
     * @return void
     * @throws AuthorizationException
     */
    public function show(LeadHistory $leadHistory)
    {
        $this->authorize('show', $leadHistory);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LeadHistory $leadHistory
     * @return void
     * @throws AuthorizationException
     */
    public function edit(LeadHistory $leadHistory)
    {
        $this->authorize('update', $leadHistory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param LeadHistory $leadHistory
     * @return void
     * @throws AuthorizationException
     */
    public function update(Request $request, LeadHistory $leadHistory)
    {
        $this->authorize('update', $leadHistory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param LeadHistory $leadHistory
     * @return void
     * @throws AuthorizationException
     */
    public function destroy(LeadHistory $leadHistory)
    {
        $this->authorize('delete', $leadHistory);
    }
}
