<?php

namespace App\Http\Controllers;

use App\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function activity_reports(Request $request){
        
        $request->input('start_date')
            ? $start_date = Carbon::parse($request->input('start_date'))->toDateTimeString()
            : $start_date = Carbon::now()->startOfMonth()->toDateTimeString();

    
        $request->input('end_date')
            ? $end_date = Carbon::parse($request->input('end_date'))->toDateTimeString()
            : $end_date = Carbon::now()->toDateTimeString();

        $request->input('activitiable_type')
            ? $activitiable_type = $request->input('activitiable_type')
            : $activitiable_type = "";
            
        $request->input('system_remark')
            ? $system_remark = $request->input('system_remark')
            : $system_remark = "";
        
        $request->input('start_date')
            ? $start = Carbon::parse($request->input('start_date'))
            : $start = Carbon::now()->startOfMonth();
        
        $request->input('end_date')
            ? $end = Carbon::parse($request->input('end_date'))->format('d M')
            : $end = Carbon::now()->format('d M');

        $labels = array();
        $data = array();
        while( $start->format('d M') <= $end){

            if($system_remark != "" || $activitiable_type != ""){

                if($system_remark == ""){
    
                    if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                        $activities = Activity::whereDate('created_at', $start)
                        ->where('activity_type',$activitiable_type)->count();
                        
                        else
                        $activities = Activity::where([['id',Auth::user()->id],['activity_type','App\User']])
                        ->whereDate('created_at', $start)
                        ->where('activity_type',$activitiable_type)
                        ->count();
                }
                elseif($activitiable_type == ""){
                    if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                        $activities = Activity::whereDate('created_at', $start)
                        ->where('system_remark',$system_remark)->count();
                        
                        else
                        $activities = Activity::where([['id',Auth::user()->id],['activity_type','App\User']])
                        ->whereDate('created_at', $start)
                        ->where('system_remark',$system_remark)
                        ->count();
                }
                else{
                    if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                        $activities = Activity::whereDate('created_at', $start)
                        ->where('system_remark',$system_remark)
                        ->where('activity_type',$activitiable_type)
                        ->count();
                        
                        else
                        $activities = Activity::where([['id',Auth::user()->id],['activity_type','App\User']])
                        ->whereDate('created_at', $start)
                        ->where('system_remark',$system_remark)
                        ->where('activity_type',$activitiable_type)
                        ->count();
                }
            }
            else{
                if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                        $activities = Activity::whereDate('created_at', $start)
                        ->count();
                        
                        else
                        $activities = Activity::where([['id',Auth::user()->id],['activity_type','App\User']])
                        ->whereDate('created_at', $start)
                        ->count();
            }
            $labels[] = $start->format('d M');
            $data[]  = $activities;
            $start = $start->addDays(1);


        }

        return $this->processResponse('data',
            [
                'labels' => $labels,
                'data' => $data
            ],
            null,'success',200,
        );
    }


}
