<?php


namespace App\Http\Controllers;

use App\Lead;
use App\LeadStatus;
use App\LeadSource;
use App\Project;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function userLeadStatusWise(Request $request)
    {
        $request->input('start_date')
            ? $start_date = Carbon::parse($request->input('start_date'))->toDateTimeString()
            : $start_date = Carbon::now()->startOfMonth()->toDateTimeString();

        $request->input('end_date')
            ? $end_date = Carbon::parse($request->input('end_date'))->toDateTimeString()
            : $end_date = Carbon::now()->toDateTimeString();

        $users = User::all();
        $lead_statuses = LeadStatus::where('status', 1)->withCount('leads')->where('parent_id', '!=', null)->get();

        foreach($users as $index => $user)
        {
            $leads = Lead::where('parent_id', null)
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->where('created_id', $user->id)
                ->get();

            $users[$index]['leads_count'] =  $leads->count();

            $leads_with_status = [];
            $sum = 0;

            foreach($lead_statuses as $child => $lead_status)
            {
                $leads_with_status[$lead_status->name] = Lead::where('lead_status_id', $lead_status->id)
                    ->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date)
                    ->where('created_id', $user->id)->count();
                $sum = $sum + $leads_with_status[$lead_status->name];
            }

            $users[$index]['lead_statuses'] = $leads_with_status;
            $users[$index]['sum'] = $sum;
        }
        //lead count lead_status_wise
        $lead_status_sum = [];
        $total_leads = 0;
        foreach($lead_statuses as $lead_status)
        {
            $lead_status_sum[$lead_status->name] = Lead::where('lead_status_id', $lead_status->id)
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->count();
            $total_leads = $total_leads + $lead_status_sum[$lead_status->name];
        }

        return $this->processResponse('success',200,null,
            [
                'users' => $users,
                'lead_statuses' => $lead_statuses,
                'lead_status_sum' => $lead_status_sum,
                'total_leads' => $total_leads
            ]
        );
    }
    public function userLeadSourceWise(Request $request)
    {
        $request->input('start_date')
            ? $start_date = Carbon::parse($request->input('start_date'))->toDateTimeString()
            : $start_date = Carbon::now()->startOfMonth()->toDateTimeString();

        $request->input('end_date')
            ? $end_date = Carbon::parse($request->input('end_date'))->toDateTimeString()
            : $end_date = Carbon::now()->toDateTimeString();
        
        $request->input('project')
            ? $project = $request->input('project')
            : $project = "";
        
        $users = User::all();
        $lead_sources = LeadSource::where('status', 'active')->withCount('leads')->get();

        foreach($users as $index => $user)
        {
            if($project != ""){

                $leads = Lead::join('lead_histories','lead_histories.lead_id','=','leads.id')
                ->join('lead_history_project','lead_history_project.lead_history_id','=','lead_histories.id')
                ->where('leads.parent_id', null)
                ->whereDate('leads.created_at', '>=', $start_date)
                ->whereDate('leads.created_at', '<=', $end_date)
                ->where('leads.created_id', $user->id)
                ->where('lead_history_project.project_id',$project)
                ->get();
            }
            else{
                $leads = Lead::where('parent_id', null)
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->where('created_id', $user->id)
                ->get();
            }
           

            $users[$index]['leads_count'] =  $leads->count();

            $leads_with_source = [];
            $sum = 0;

            foreach($lead_sources as $child => $lead_source)
            {
                if($project != ""){

                    $leads_with_source[$lead_source->name] = Lead::join('lead_histories','lead_histories.lead_id','=','leads.id')
                    ->join('lead_history_project','lead_history_project.lead_history_id','=','lead_histories.id')
                    ->where('lead_source_id', $lead_source->id)
                    ->whereDate('leads.created_at', '>=', $start_date)
                    ->whereDate('leads.created_at', '<=', $end_date)
                    ->where('lead_history_project.project_id',$project)
                    ->where('leads.created_id', $user->id)->count();
                }
                else{
                    $leads_with_source[$lead_source->name] = Lead::where('lead_source_id', $lead_source->id)
                    ->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date)
                    ->where('created_id', $user->id)->count();
                }
                
                $sum = $sum + $leads_with_source[$lead_source->name];
            }

            $users[$index]['lead_sources'] = $leads_with_source;
            $users[$index]['sum'] = $sum;
        }
        //lead count lead_source_wise
        $lead_source_sum = [];
        $total_leads = 0;
        foreach($lead_sources as $lead_source)
        {
            if($project != ""){
                $lead_source_sum[$lead_source->name] = Lead::join('lead_histories','lead_histories.lead_id','=','leads.id')
                ->join('lead_history_project','lead_history_project.lead_history_id','=','lead_histories.id')
                ->where('leads.lead_source_id', $lead_source->id)
                ->whereDate('leads.created_at', '>=', $start_date)
                ->whereDate('leads.created_at', '<=', $end_date)
                ->where('lead_history_project.project_id',$project)
                ->count();
            }
            else{
                $lead_source_sum[$lead_source->name] = Lead::where('lead_source_id', $lead_source->id)
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->count();
            }
            
            $total_leads = $total_leads + $lead_source_sum[$lead_source->name];
        }

        return $this->processResponse('success',200,null,
            [
                'users' => $users,
                'lead_sources' => $lead_sources,
                'lead_source_sum' => $lead_source_sum,
                'total_leads' => $total_leads
            ]
        );
    }

    public function userLeadProjectWise(Request $request)
    {
        $request->input('start_date')
            ? $start_date = Carbon::parse($request->input('start_date'))->toDateTimeString()
            : $start_date = Carbon::now()->startOfMonth()->toDateTimeString();

        $request->input('end_date')
            ? $end_date = Carbon::parse($request->input('end_date'))->toDateTimeString()
            : $end_date = Carbon::now()->toDateTimeString();

        $request->input('source')
            ? $source = $request->input('source')
            : $source = "";

        $users = User::all();
        $lead_projects = Project::where('status', 'active')->get();

        foreach($users as $index => $user)
        {
            if($source != ""){
            $leads = Lead::where('parent_id', null)
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->where('lead_source_id',$source)
                ->where('created_id', $user->id)
                ->get();
            }
            else{
                $leads = Lead::where('parent_id', null)
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->where('created_id', $user->id)
                ->get();
            }

            $users[$index]['leads_count'] =  $leads->count();

            $leads_with_project = [];
            $sum = 0;

            foreach($lead_projects as $child => $lead_project)
            {
                if($source!=""){
                $leads_with_project[$lead_project->name] = Lead::join('lead_histories','lead_histories.lead_id','=','leads.id')
                    ->join('lead_history_project','lead_history_project.lead_history_id','=','lead_histories.id')
                    ->select('leads.*')
                    ->whereDate('leads.created_at', '>=', $start_date)
                    ->whereDate('leads.created_at', '<=', $end_date)
                    ->where('leads.lead_source_id',$source)
                    ->where('lead_history_project.project_id',$lead_project->id)
                    ->where('leads.created_id', $user->id)->count();
                }
                else{
                    $leads_with_project[$lead_project->name] = Lead::join('lead_histories','lead_histories.lead_id','=','leads.id')
                    ->join('lead_history_project','lead_history_project.lead_history_id','=','lead_histories.id')
                    ->select('leads.*')
                    ->whereDate('leads.created_at', '>=', $start_date)
                    ->whereDate('leads.created_at', '<=', $end_date)
                    ->where('lead_history_project.project_id',$lead_project->id)
                    ->where('leads.created_id', $user->id)->count();
                }

                $sum = $sum + $leads_with_project[$lead_project->name];
            }

            $users[$index]['lead_projects'] = $leads_with_project;
            $users[$index]['sum'] = $sum;
        }
        //lead count lead_source_wise
        $lead_project_sum = [];
        $total_leads = 0;
        foreach($lead_projects as $lead_project)
        {
            if($source != ""){
                $lead_project_sum[$lead_project->name] = Lead::join('lead_histories','lead_histories.lead_id','=','leads.id')
                ->join('lead_history_project','lead_history_project.lead_history_id','=','lead_histories.id')
                ->select('leads.*')
                ->whereDate('leads.created_at', '>=', $start_date)
                ->whereDate('leads.created_at', '<=', $end_date)
                ->where('lead_history_project.project_id',$lead_project->id)
                ->where('leads.lead_source_id',$source)
                ->count();
            }
            else{
                $lead_project_sum[$lead_project->name] = Lead::join('lead_histories','lead_histories.lead_id','=','leads.id')
                ->join('lead_history_project','lead_history_project.lead_history_id','=','lead_histories.id')
                ->select('leads.*')
                ->whereDate('leads.created_at', '>=', $start_date)
                ->whereDate('leads.created_at', '<=', $end_date)
                ->where('lead_history_project.project_id',$lead_project->id)
                ->count();
            }

            $total_leads = $total_leads + $lead_project_sum[$lead_project->name];
        }

        return $this->processResponse('success',200,null,
            [
                'users' => $users,
                'lead_projects' => $lead_projects,
                'lead_project_sum' => $lead_project_sum,
                'total_leads' => $total_leads
            ]
        );
    }

    public function qualifiedLeadsUserWise(Request $request)
    {
        $request->input('start_date')
            ? $start_date = Carbon::parse($request->input('start_date'))->toDateTimeString()
            : $start_date = Carbon::now()->startOfMonth()->toDateTimeString();

        $request->input('end_date')
            ? $end_date = Carbon::parse($request->input('end_date'))->toDateTimeString()
            : $end_date = Carbon::now()->toDateTimeString();
        
        $users = User::all();

        foreach($users as $index => $user)
        {
            
                $leads = Lead::join('lead_user','lead_user.lead_id','=','leads.id')
                ->where('leads.parent_id', null)
                ->whereDate('lead_user.created_at', '>=', $start_date)
                ->whereDate('lead_user.created_at', '<=', $end_date)
                ->where('leads.created_id', $user->id)
                ->get();
            
           

            $users[$index]['leads_count'] =  $leads->count();

            $qualified_leads = [];
            $sum = 0;

            foreach($users as $child => $assignee)
            {
                $qualified_leads[$assignee->id] = $leads = Lead::join('lead_user','lead_user.lead_id','=','leads.id')
                ->where('parent_id', null)
                ->whereDate('lead_user.created_at', '>=', $start_date)
                ->whereDate('lead_user.created_at', '<=', $end_date)
                ->where('leads.created_id', $user->id)
                ->where('lead_user.user_id',$assignee->id)
                ->count();
               
                
                $sum = $sum + $qualified_leads[$assignee->id];
            }

            $users[$index]['qualified_leads'] = $qualified_leads;
            $users[$index]['sum'] = $sum;
        }
        //lead count lead_source_wise
        $qualified_leads_sum = [];
        $total_leads = 0;
        foreach($users as $assignee)
        {
                $qualified_leads_sum[$assignee->id] = Lead::join('lead_user','lead_user.lead_id','=','leads.id')
                ->where('parent_id', null)
                ->whereDate('lead_user.created_at', '>=', $start_date)
                ->whereDate('lead_user.created_at', '<=', $end_date)
                ->where('lead_user.user_id',$assignee->id)
                ->count();
            
            $total_leads = $total_leads + $qualified_leads_sum[$assignee->id];
        }

        return $this->processResponse('success',200,null,
            [
                'users' => $users,
                'qualified_leads_sum' => $qualified_leads_sum,
                'total_leads' => $total_leads
            ]
        );
    }
    public function deadLeadsUserWise(Request $request)
    { 
        $request->input('start_date')
            ? $start_date = Carbon::parse($request->input('start_date'))->toDateTimeString()
            : $start_date = Carbon::now()->startOfMonth()->toDateTimeString();

    
        $request->input('end_date')
            ? $end_date = Carbon::parse($request->input('end_date'))->toDateTimeString()
            : $end_date = Carbon::now()->toDateTimeString();

        $request->input('status')
            ? $parent_status = $request->input('status')
            : $parent_status = 2;

        $users = User::all();
        $lead_statuses = LeadStatus::where('status', 1)->withCount('leads')->where('parent_id', $parent_status)->get();

        foreach($users as $index => $user)
        {
            $leads = Lead::where('parent_id', null)
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->where('created_id', $user->id)
                ->get();

            $users[$index]['leads_count'] =  $leads->count();

            $leads_with_status = [];
            $sum = 0;

            foreach($lead_statuses as $child => $lead_status)
            {
                $leads_with_status[$lead_status->name] = Lead::where('lead_status_id', $lead_status->id)
                    ->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date)
                    ->where('created_id', $user->id)->count();
                $sum = $sum + $leads_with_status[$lead_status->name];
            }

            $users[$index]['lead_statuses'] = $leads_with_status;
            $users[$index]['sum'] = $sum;
        }
        //lead count lead_status_wise
        $lead_status_sum = [];
        $total_leads = 0;
        foreach($lead_statuses as $lead_status)
        {
            $lead_status_sum[$lead_status->name] = Lead::where('lead_status_id', $lead_status->id)
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->count();
            $total_leads = $total_leads + $lead_status_sum[$lead_status->name];
        }

        return $this->processResponse('success',200,null,
            [
                'users' => $users,
                'lead_statuses' => $lead_statuses,
                'lead_status_sum' => $lead_status_sum,
                'total_leads' => $total_leads
            ]
        );
    }
    public function dailyReport(Request $request)
    { 
        $request->input('start_date')
            ? $start_date = Carbon::parse($request->input('start_date'))->toDateTimeString()
            : $start_date = Carbon::now()->startOfDay()->toDateTimeString();

    
        $request->input('end_date')
            ? $end_date = Carbon::parse($request->input('end_date'))->toDateTimeString()
            : $end_date = Carbon::now()->toDateTimeString();

        $request->input('source')
            ? $source = $request->input('source')
            : $source = "";

        if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
        $users = User::all();
        else
        $users = User::where([['id',Auth::user()->id],['parent_id',Auth::user()->id]])->get();

        $lead_statuses = LeadStatus::where('status', 1)->withCount('leads')->where('parent_id',NULL)->get();

        foreach($users as $index => $user)
        {
            if($source != ""){
                $leads = Lead::where('parent_id', null)
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->where('created_id', $user->id)
                ->where('lead_source_id',$source)
                ->get();

                $qualifiedLeads  = Lead::join('lead_user','lead_user.lead_id','=','leads.id')
                ->where('leads.parent_id', null)
                ->whereDate('lead_user.created_at', '>=', $start_date)
                ->whereDate('lead_user.created_at', '<=', $end_date)
                ->where('leads.created_id', $user->id)
                ->where('leads.lead_source_id',$source)
                ->count();

                $receivedLeads = Lead::where('parent_id', null)
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->where('created_id', $user->id)
                ->where('leads.lead_source_id',$source)
                ->count();

                $leadsDone  = Lead::join('lead_histories','lead_histories.lead_id','=','leads.id')
                ->where('leads.parent_id', null)
                ->whereDate('lead_histories.created_at', '>=', $start_date)
                ->whereDate('lead_histories.created_at', '<=', $end_date)
                ->where('lead_histories.created_id', $user->id)
                ->where('leads.lead_source_id',$source)
                ->count();            
            }else{
                $leads = Lead::where('parent_id', null)
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->where('created_id', $user->id)
                ->get();

                $qualifiedLeads  = Lead::join('lead_user','lead_user.lead_id','=','leads.id')
                ->where('leads.parent_id', null)
                ->whereDate('lead_user.created_at', '>=', $start_date)
                ->whereDate('lead_user.created_at', '<=', $end_date)
                ->where('leads.created_id', $user->id)
                ->count();

                $receivedLeads = Lead::where('parent_id', null)
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->where('created_id', $user->id)
                ->count();

                $leadsDone  = Lead::join('lead_histories','lead_histories.lead_id','=','leads.id')
                ->where('leads.parent_id', null)
                ->whereDate('lead_histories.created_at', '>=', $start_date)
                ->whereDate('lead_histories.created_at', '<=', $end_date)
                ->where('lead_histories.created_id', $user->id)
                ->count();  
            }            
            $users[$index]['leads_done_count'] = $leadsDone;
            $users[$index]['received_leads_count'] = $receivedLeads;
            $users[$index]['qualified_leads_count'] = $qualifiedLeads;
            $users[$index]['leads_count'] =  $leads->count();

            $leads_with_status = [];
            $sum = 0;

            foreach($lead_statuses as $child => $lead_status)
            {
                if($source != ""){
                    $leads_with_status[$lead_status->name] = Lead::whereIn('lead_status_id', $lead_status->children->pluck('id'))
                    ->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date)
                    ->where('created_id', $user->id)
                    ->where('lead_source_id',$source)
                    ->count();
                }
                else{
                    $leads_with_status[$lead_status->name] = Lead::whereIn('lead_status_id', $lead_status->children->pluck('id'))
                    ->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date)
                    ->where('created_id', $user->id)
                    ->count();
                }
                $sum = $sum + $leads_with_status[$lead_status->name];
                
            }
            
            $users[$index]['lead_statuses'] = $leads_with_status;
            $users[$index]['sum'] = $sum;
        }
        //lead count lead_status_wise
        $lead_status_sum = [];
        $total_leads = 0;
        foreach($lead_statuses as $lead_status)
        {
            if($source != ""){
                $lead_status_sum[$lead_status->name] = Lead::whereIn('lead_status_id', $lead_status->children->pluck('id'))
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->where('lead_source_id',$source)
                ->count();
            }
            else{
                $lead_status_sum[$lead_status->name] = Lead::whereIn('lead_status_id', $lead_status->children->pluck('id'))
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->count();
            }
            $total_leads = $total_leads + $lead_status_sum[$lead_status->name];
        }
            if($source != ""){
                $totalQualifiedLeads  = Lead::join('lead_user','lead_user.lead_id','=','leads.id')
                ->where('leads.parent_id', null)
                ->whereDate('lead_user.created_at', '>=', $start_date)
                ->whereDate('lead_user.created_at', '<=', $end_date)
                ->where('leads.lead_source_id',$source)
                ->count();

                $totalReceivedLeads = Lead::where('leads.parent_id', null)
                ->whereDate('leads.created_at', '>=', $start_date)
                ->whereDate('leads.created_at', '<=', $end_date)
                ->where('leads.lead_source_id',$source)
                ->count();

                $totalLeadsDone  = Lead::join('lead_histories','lead_histories.lead_id','=','leads.id')
                ->where('leads.parent_id', null)
                ->whereDate('lead_histories.created_at', '>=', $start_date)
                ->whereDate('lead_histories.created_at', '<=', $end_date)
                ->where('leads.lead_source_id',$source)
                ->count();
            }
            else{
                $totalQualifiedLeads  = Lead::join('lead_user','lead_user.lead_id','=','leads.id')
                ->where('leads.parent_id', null)
                ->whereDate('lead_user.created_at', '>=', $start_date)
                ->whereDate('lead_user.created_at', '<=', $end_date)
                ->count();

                $totalReceivedLeads = Lead::where('leads.parent_id', null)
                ->whereDate('leads.created_at', '>=', $start_date)
                ->whereDate('leads.created_at', '<=', $end_date)
                ->count();

                $totalLeadsDone  = Lead::join('lead_histories','lead_histories.lead_id','=','leads.id')
                ->where('leads.parent_id', null)
                ->whereDate('lead_histories.created_at', '>=', $start_date)
                ->whereDate('lead_histories.created_at', '<=', $end_date)
                ->count();
            }

        return $this->processResponse('success',200,null,
            [
                'users' => $users,
                'lead_statuses' => $lead_statuses,
                'lead_status_sum' => $lead_status_sum,
                'total_leads_done' =>$totalLeadsDone,
                'total_qualified_leads'=>$totalQualifiedLeads,
                'total_received_leads' =>$totalReceivedLeads,
                'total_leads' => $total_leads
            ]
        );
    }
}
