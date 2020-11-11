<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Helper\LogActivity;
use App\Lead;
use App\User;
use App\Mail\NewLead;
use App\Mail\LeadAssignedMailToAdmin;
use App\Mail\LeadAssignedMailToUser;
use Carbon\Carbon;
use Exception;
use App\LeadSource;
use App\LeadStatus;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Builder;
use App\Jobs\SendEmail;

class LeadController extends Controller
{

    public function import(Request $request)
    {
        $rows = json_decode(json_encode($request->input('rows')), FALSE);
        $defaultLeadSource = Config::get('settings.leads.default_lead_source');
        $defaultLeadStatus = Config::get('settings.default_lead_status');
        $loggedInUserId = Auth::user()->id;
        $count = [
            'total' => 0,
            'imported' => 0,
            'duplicate' => 0,
        ];
        $batch = Carbon::now()->timestamp;

        DB::beginTransaction();
        foreach($rows as $row)
        {
            ++$count['total'];
            $parentPresent = Helper::searchParentLead($row->number);
            $newLead = [
                'parent_id' => $parentPresent ? $parentPresent->id : null,
                'name' => $row->name,
                'email' => property_exists($row,'email') ? $row->email : null,
                'mobile' => $row->number,
                'project' => property_exists($row,'project') ? $row->project : null,
                'budget' => property_exists($row,'$row,budget') ? $row->budget : null,
                'remarks' => property_exists($row,'remarks') ? $row->remarks : null,
                'lead_source_id' => property_exists($row,'source') ? $row->source : $defaultLeadSource,
                'lead_status_id' => property_exists($row,'status') ? $row->status : $defaultLeadStatus,
                'batch' => $batch,
                'created_id' => $parentPresent ? $parentPresent->created_id : (property_exists($row,'owner' ) ? $row->owner : $loggedInUserId),
                'created_at' => property_exists($row,'received_on') ? Carbon::parse($row->received_on) : Carbon::now()
            ];

            if(!Helper::isLeadDuplicate($row)) {
                Lead::create($newLead);
                ++$count['imported'];
            } else {
                ++$count['duplicate'];
            }

        }
        DB::commit();
        return $this->processResponse('success', 200, 'Leads imported!', $count);
    }

    /**
     * @param null $start_date
     * @param null $end_date
     */
//    public function getFollowUpLeads($start_date = null, $end_date = null)
//    {
//        $start_date ? $start_date : $start_date = Carbon::now()->today();
//        $end_date ? $end_date : $end_date = Carbon::now();
//
//        $leads = Lead::with(['lead_history', 'lead_status', 'lead_source'])
//            ->whereHas('lead_history', function($query) use($start_date, $end_date) {
//                $query->where('follow_up_at','!=',null)
//                    ->where('completed',false)
//                    ->whereBetween('follow_up_at', array($start_date, $end_date)); })
//            ->get();
//
//        $this->processResponse('success', 200, null, $leads);
//    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->role_id == 1 || $user->role_id == 2 ? true : false;
        $this->authorize('viewAny', Lead::class);

        $name = ($request->input('name')) ? $request->input('name') : '';
        $mobile = ($request->input('mobile')) ? $request->input('mobile') : '';
        $email = ($request->input('email')) ? $request->input('email') : '';
        $follow_up_at = ($request->input('follow_up_at')) ? $request->input('follow_up_at') : '';
        $remarks = ($request->input('remarks')) ? $request->input('remarks') : '';
        $lead_source = ($request->input('lead_source')) ? $request->input('lead_source') : '';
        $lead_status = ($request->input('lead_status')) ? $request->input('lead_status') : '';
        $lead_owner = ($request->input('lead_owner')) ? $request->input('lead_owner') : '';
        $created_at = ($request->input('created_at')) ? $request->input('created_at') : '';

        if(!$isAdmin){
            $leads = Lead::search('name',$name)
                ->search('mobile', $mobile)
                ->search('email', $email)
                ->search('follow_up_at', $follow_up_at)
                ->search('created_at', $created_at)
                ->search('remarks', $remarks)
                ->searchManyStrict('name', $lead_owner,'created_by')
                ->searchManyStrict('name', $lead_source,'lead_source')
                ->searchManyStrict('name', $lead_status,'lead_status')
                ->with(['lead_source', 'lead_status', 'created_by', 'updated_by', 'lead_history_remarks',
                    'parent.lead_source', 'parent.lead_source', 'parent.lead_status', 'parent.created_by', 'parent.updated_by',
                    'lead_history.historical', 'lead_history_followup_count','lead_history.created_by', 'lead_history.projects', 'assignedUsers'])
                ->where('created_id', $user->id)
                ->orWhereHas('assignedUsers', function(Builder $query) use($user) {
                    $query->where('user_id',$user->id);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(Config::get('settings.pagination'));
        } else {
            $leads =  Lead::search('name',$name)
                ->search('mobile', $mobile)
                ->search('email', $email)
                ->search('follow_up_at', $follow_up_at)
                ->search('created_at', $created_at)
                ->search('remarks', $remarks)
                ->searchManyStrict('name', $lead_owner,'created_by')
                ->searchManyStrict('name', $lead_source,'lead_source')
                ->searchManyStrict('name', $lead_status,'lead_status')
                ->with(['lead_source', 'lead_status', 'created_by', 'updated_by', 'lead_history_remarks',
                    'parent.lead_source', 'parent.lead_source', 'parent.lead_status', 'parent.created_by', 'parent.updated_by',
                    'lead_history.historical', 'lead_history.created_by', 'lead_history.projects'])
                ->orderBy('created_at', 'desc')
                ->paginate(Config::get('settings.pagination'));
        }

        return $this->processResponse('success', 200, null, $leads);
    }
    public function unattendedLeads(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->role_id == 1 || $user->role_id == 2 ? true : false;
        $this->authorize('viewAny', Lead::class);

        $name = ($request->input('name')) ? $request->input('name') : '';
        $mobile = ($request->input('mobile')) ? $request->input('mobile') : '';
        $email = ($request->input('email')) ? $request->input('email') : '';
        $follow_up_at = ($request->input('follow_up_at')) ? $request->input('follow_up_at') : '';
        $remarks = ($request->input('remarks')) ? $request->input('remarks') : '';
        $lead_source = ($request->input('lead_source')) ? $request->input('lead_source') : '';
        $lead_status = ($request->input('lead_status')) ? $request->input('lead_status') : '';
        $lead_owner = ($request->input('lead_owner')) ? $request->input('lead_owner') : '';
        $created_at = ($request->input('created_at')) ? $request->input('created_at') : '';

        if(!$isAdmin){
            $leads = Lead::search('name',$name)
                ->search('mobile', $mobile)
                ->search('email', $email)
                ->search('follow_up_at', $follow_up_at)
                ->search('created_at', $created_at)
                ->search('remarks', $remarks)
                ->searchManyStrict('name', $lead_owner,'created_by')
                ->searchManyStrict('name', $lead_source,'lead_source')
                ->searchManyStrict('name', $lead_status,'lead_status')
                ->with(['lead_source', 'lead_status', 'created_by', 'updated_by', 'lead_history_remarks',
                    'parent.lead_source', 'parent.lead_source', 'parent.lead_status', 'parent.created_by', 'parent.updated_by',
                    'lead_history.historical', 'lead_history.created_by', 'lead_history.projects', 'assignedUsers'])
                ->where('leads.created_id',$user->id)
                ->orWhereHas('assignedUsers', function(Builder $query) use($user) {
                   $query->where('user_id',$user->id);
                })
                ->whereDate('leads.created_at','<=' ,Carbon::now()->subDays(5))
                ->select('leads.*')
                ->doesnthave('lead_history')
                ->orWhereHas('lead_history', function( $query ){
                    $query->latest()->where('created_at','<=' ,Carbon::now()->subDays(5));
                })
                ->orderBy('leads.created_at', 'desc')
                ->paginate(Config::get('settings.pagination'));
        } else {
            $leads =  Lead::search('name',$name)
            ->search('mobile', $mobile)
            ->search('email', $email)
            ->search('follow_up_at', $follow_up_at)
            ->search('created_at', $created_at)
            ->search('remarks', $remarks)
            ->searchManyStrict('name', $lead_owner,'created_by')
            ->searchManyStrict('name', $lead_source,'lead_source')
            ->searchManyStrict('name', $lead_status,'lead_status')
            ->with(['lead_source', 'lead_status', 'created_by', 'updated_by','lead_history_remarks',
                'parent.lead_source', 'parent.lead_source', 'parent.lead_status', 'parent.created_by', 'parent.updated_by',
                'lead_history.historical', 'lead_history.created_by', 'lead_history.projects'])
            ->whereDate('leads.created_at','<=' ,Carbon::now()->subDays(5))
            ->select('leads.*')
            ->doesnthave('lead_history')
            ->orWhereHas('lead_history', function( $query ){
                $query->latest()->where('created_at','<=' ,Carbon::now()->subDays(5));
            })
            ->orderBy('leads.created_at', 'desc')
            ->paginate(Config::get('settings.pagination'));
        }

        return $this->processResponse('success', 200, null, $leads);
    }

    public function userAssignedLeads(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->role_id == 1 || $user->role_id == 2 ? true : false;
        $this->authorize('viewAny', Lead::class);

        $name = ($request->input('name')) ? $request->input('name') : '';
        $mobile = ($request->input('mobile')) ? $request->input('mobile') : '';
        $email = ($request->input('email')) ? $request->input('email') : '';
        $follow_up_at = ($request->input('follow_up_at')) ? $request->input('follow_up_at') : '';
        $remarks = ($request->input('remarks')) ? $request->input('remarks') : '';
        $lead_source = ($request->input('lead_source')) ? $request->input('lead_source') : '';
        $lead_status = ($request->input('lead_status')) ? $request->input('lead_status') : '';
        $lead_owner = ($request->input('lead_owner')) ? $request->input('lead_owner') : '';
        $created_at = ($request->input('created_at')) ? $request->input('created_at') : '';

        if(!$isAdmin){
            $leads = Lead::join('lead_user','lead_user.lead_id','=','leads.id')
                ->search('name',$name)
                ->search('mobile', $mobile)
                ->search('email', $email)
                ->search('follow_up_at', $follow_up_at)
                ->search('created_at', $created_at)
                ->search('remarks', $remarks)
                ->searchManyStrict('name', $lead_owner,'created_by')
                ->searchManyStrict('name', $lead_source,'lead_source')
                ->searchManyStrict('name', $lead_status,'lead_status')
                ->with(['lead_source', 'lead_status', 'created_by', 'updated_by', 'lead_history_remarks',
                    'parent.lead_source', 'parent.lead_source', 'parent.lead_status', 'parent.created_by', 'parent.updated_by',
                    'lead_history.historical', 'lead_history.created_by', 'lead_history.projects', 'assignedUsers'])
                ->where('lead_user.user_id',$user->id)
                //->where('created_id', $user->id)
                //->orWhereHas('assignedUsers', function(Builder $query) use($user) {
                //    $query->where('user_id',$user->id);
                //})
                ->select('leads.*','lead_user.created_at as assigned_at')
                ->orderBy('lead_user.created_at', 'desc')
                ->paginate(Config::get('settings.pagination'));
        } else {
            $users = User::pluck('id');

            $leads =  Lead::join('lead_user','lead_user.lead_id','=','leads.id')
                ->search('name',$name)
                ->search('mobile', $mobile)
                ->search('email', $email)
                ->search('follow_up_at', $follow_up_at)
                ->search('created_at', $created_at)
                ->search('remarks', $remarks)
                ->searchManyStrict('name', $lead_owner,'created_by')
                ->searchManyStrict('name', $lead_source,'lead_source')
                ->searchManyStrict('name', $lead_status,'lead_status')
                ->with(['lead_source', 'lead_status', 'created_by','assignedUsers', 'updated_by', 'lead_history_remarks',
                    'parent.lead_source', 'parent.lead_source', 'parent.lead_status', 'parent.created_by', 'parent.updated_by',
                    'lead_history.historical', 'lead_history.created_by', 'lead_history.projects',])
                ->whereIn('lead_user.user_id',$users)
                ->orderBy('lead_user.created_at', 'desc')
                ->select('leads.*','lead_user.created_at as assigned_at')
                //->groupBy('leads.name')
                ->distinct()
                ->paginate(Config::get('settings.pagination'));
        }

        return $this->processResponse('success', 200, null, $leads);
    }
    /**
     * Lists of leads to be followed up from now till the end of the day.
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function currentDayLeads()
    {
        $this->authorize('viewAny', Lead::class);

        $user = Auth::user();
        $isAdmin = $user->role_id == 1 || $user->role_id == 2 ? true : false;

        if(!$isAdmin) {
            $leads = Lead::where('follow_up_at', '>=', Carbon::now()->startOfDay())
                ->where('follow_up_at', '<=', Carbon::now()->endOfDay())
                ->with(['lead_source', 'lead_status', 'lead_history','created_by', 'updated_by', 'lead_history_remarks',
                    'parent.lead_source', 'parent.lead_source', 'parent.lead_status', 'parent.created_by', 'parent.updated_by',
                    'lead_history.historical',  'lead_history.created_by', 'lead_history.projects'])
                ->where('created_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $leads = Lead::where('follow_up_at', '>=', Carbon::now()->startOfDay())
                ->where('follow_up_at', '<=', Carbon::now()->endOfDay())
                ->with(['lead_source', 'lead_status', 'lead_history', 'created_by', 'updated_by', 'lead_history_remarks',
                    'parent.lead_source', 'parent.lead_source', 'parent.lead_status', 'parent.created_by', 'parent.updated_by',
                    'lead_history.historical', 'lead_history.created_by', 'lead_history.projects'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return $this->processResponse('success', 200, null, $leads);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Lead::class);

        $lead['assigned_users'] = [];
        $lead['lead_statuses'] = LeadStatus::where('status', 'active')->get();
        $lead['lead_sources'] = LeadSource::where('status', 'active')->get();
//        $lead['all_active_projects'] = Project::where('status', 'active')->get();

        return $this->processResponse('success',200,null,$lead);
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

        if($request->has('id')) {

            $l = Lead::find($request->input('id'));
            $message = 'Lead updated!';

            $request->validate([
                'name' => 'required',
            ]);
        } else {
            $l = null;
            $message = 'Lead created!';

            $request->validate([
                'name' => 'required',
                'lead_source_id' => 'required',
                'lead_status_id' => 'required',
            ]);
        }

        DB::beginTransaction();

        $parentPresent = Helper::searchParentLead($request->input('mobile'));

        $lead = Lead::updateOrcreate(
            ['id' => $request->input('id')],
            [
                'parent_id' => $parentPresent ? $parentPresent->id != $request->input('id') ? $parentPresent->id : null : null,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'project' => $request->input('project'),
                'project_type' => $request->input('project_type'),
                'budget' => $request->input('budget'),
                'remarks' => $request->input('remarks'),
                'lead_source_id' => ($request->input('lead_source_id')) ? $request->input('lead_source_id') : $l->lead_source_id,
                'lead_status_id' => ($request->input('lead_status_id')) ? $request->input('lead_status_id') : $l->lead_status_id,
                'updated_id' => $request->id ? Auth::user()->id : null,
                'created_id' => !$request->id && $parentPresent ? $parentPresent->created_id : Auth::user()->id,
            ]
        );

        if($request->assigned_users)
        {
            $lead->assignedUsers()->detach();

            foreach($request->assigned_users as $user)
            {
                $lead->assignedUsers()->attach($user['id']);
            }
        } else {
            $lead->assignedUsers()->detach();
        }

        DB::commit();

        if($request->has('id'))
        {
            LogActivity::add(Auth::user(), 'ActivityLabels::_LEAD_UPDATED');
        } else {
            LogActivity::add(Auth::user(), 'ActivityLabels::_LEAD_CREATED');
            Mail::to(Auth::user()->email)->send(new NewLead(Auth::user(), $lead));
        }

        return $this->processResponse('success',200,$message,$lead);
    }

    /**
     * Display the specified resource.
     *
     * @param Lead $lead
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(Lead $lead)
    {
        $this->authorize('view', $lead);

        $lead = Lead::with(
            ['lead_history.historical', 'lead_history.created_by', 'lead_history.projects', 'lead_status',
            'lead_source', 'comments.created_by', 'comments.updated_by',
            'comments.children.created_by' ,'comments.children.updated_by', 'assignedUsers'])
            ->find($lead->id);

        LogActivity::add(Auth::user(), 'ActivityLabels::_LEAD_SHOW_VIEWED');

        return $this->processResponse('success',200,null,$lead);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Lead $lead
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function edit(Lead $lead)
    {
        $this->authorize('update', $lead);

        $lead = Lead::with(['lead_status', 'lead_source', 'assignedUsers'])->find($lead->id);
        $lead['lead_statuses']= LeadStatus::where('status', 'active')->get();
        $lead['lead_sources'] = LeadSource::where('status', 'active')->get();

        return $this->processResponse('success',200,null,$lead);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Lead $lead
     * @return void
     */
    public function update(Request $request, Lead $lead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lead $lead
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Lead $lead)
    {
        $this->authorize('delete', $lead);

       if($lead->lead_history->count() > 0)
       {
           return $this->processResponse('error',404,'Lead has statues history linked, cannot be deleted!',null);
       }

       if($lead->comments->count() > 0)
       {
           return $this->processResponse('error',404,'Lead has comments, cannot be deleted!',null);
       }

       DB::beginTransaction();

       $lead->delete();
       $lead->children()->delete();
       $lead->assignedUsers()->detach();

       DB::commit();

        LogActivity::add(Auth::user(),  'ActivityLabels::_LEAD_DELETED');

       return $this->processResponse('success',200,'Lead deleted!',$lead);
    }

    public function changeOwner(Request $request)
    {
        $lead = Lead::find($request->input('lead_id'));

        $this->authorize('transferOwner', $lead);

        $request->validate([
            'lead_id' => 'required',
            'user_id' => 'required',
        ]);

        $lead->created_id = $request->user_id;
        $lead->save();

        //change lead-children owner too

        foreach($lead->children as $child){
            $child->created_id = $request->user_id;
            $child->save();
        }

        //change lead-children owner too

        foreach($lead->children as $child){
            $child->created_id = $request->user_id;
            $child->save();
        }

        LogActivity::add(Auth::user(), 'ActivityLabels::_LEAD_TRANSFERRED');

        return $this->processResponse('success',200,'Lead owner changed',$lead);
    }

    public function changeOwnerBulk(Request $request)
    {
        foreach($request->input('leads') as $lead_id)
        {
            $lead = Lead::find($lead_id);
            $lead->created_id = $request->user;
            $lead->save();

            //change lead-children owner too

            foreach($lead->children as $child){
                $child->created_id = $request->user_id;
                $child->save();
            }
        }

        LogActivity::add(Auth::user(), 'ActivityLabels::_LEAD_TRANSFERRED');

        return $this->processResponse('success',200,'Leads ownership transferred',null);
    }

    public function leadAssignmentBulk(Request $request)
    {
        $leads_id = $request->input('leads');
        $user_id = $request->input('user');
       
      DB::beginTransaction();
        foreach($leads_id as $lead_id)
        {
            $lead = Lead::find($lead_id);
            $lead->assignedUsers()->sync($user_id);

            $user = User::find($user_id);
            SendEmail::dispatch($user, $lead);
            
        }

        DB::commit();

        LogActivity::add(Auth::user(), 'ActivityLabels::_LEAD_ASSIGNED');

        return $this->processResponse('success',200,'Bulk assignment completed',null);
    }

    public function leadChildren(Request $request)
    {
        $children = Lead::with(['children.lead_source', 'children.lead_status'])->find($request->input('id'));

        return $this->processResponse('success',200,null,$children);
    }
}
