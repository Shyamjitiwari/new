<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function markUserAttendanceByAdmin(Request $request){

        $request->validate([
            'user_id' => 'required',
            'type' => 'required',
            'date' => 'required'
        ]);

       
            // dd(Attendance::where('user_id',$request->input('user_id'))
            // ->where([['date','>=',Carbon::parse($request->input('date'))->startOfDay()],['date','<=',Carbon::parse($request->input('date'))->endOfDay()]])
            // ->where('type','absent')
            // ->orWhere('type','check_out')
            // ->count());
        if(Attendance::where('user_id',$request->input('user_id'))
            ->where([['date','>=',Carbon::parse($request->input('date'))->startOfDay()],['date','<=',Carbon::parse($request->input('date'))->endOfDay()]])
            ->where('type',$request->input('type'))
            ->count()){

                return $this->processResponse('success',200,'User is already marked as '.$request->input('type'),null);
        }
        elseif(Attendance::where('user_id',$request->input('user_id'))
            ->where([['date','>=',Carbon::parse($request->input('date'))->startOfDay()],['date','<=',Carbon::parse($request->input('date'))->endOfDay()]])
            ->where('type','absent')
            ->count()
             || 
             Attendance::where('user_id',$request->input('user_id'))
            ->where([['date','>=',Carbon::parse($request->input('date'))->startOfDay()],['date','<=',Carbon::parse($request->input('date'))->endOfDay()]])
            ->where('type','check_out')
            ->count()){

        
                return $this->processResponse('success',200,'User is supposed to be absent or attendance is completed for today !!',null);
        }
        elseif(Attendance::where('user_id',$request->input('user_id'))
        ->where([['date','>=',Carbon::parse($request->input('date'))->startOfDay()],['date','<=',Carbon::parse($request->input('date'))->endOfDay()]])
        ->where('type','check_in')
        ->count() && $request->input('type') == 'absent'){

            return $this->processResponse('success',200,'User is checked in can not mark Absent!!',null);
        }
        else{

            $attendance = new Attendance;
            $attendance->user_id = $request->input('user_id');
            $attendance->type = $request->input('type');
            $attendance->date = Carbon::parse($request->input('date'))->toDateTimeString();
            $attendance->created_id = Auth::id();
            $attendance->save();
            return $this->processResponse('success',200,'Attendance marked!',$attendance);
        }     
    }

    public function markUserAttendance(Request $request){
        
        $request->validate([
            'user_id' => 'required',
        ]);

        if(User::find($request->input('user_id'))->isAbsentForToday()){
            return $this->processResponse('success',200,'Can not mark attendance, you are supposed to be absent today!',null);
        }
        else if(!User::find($request->input('user_id'))->isAttendanceMarked()){

            $attendance = new Attendance;
            $attendance->user_id = $request->input('user_id');
            $attendance->type = 'check_in';
            $attendance->date = Carbon::now();
            $attendance->created_id = Auth::id();
            $attendance->save();
        
            return $this->processResponse('success',200,'Attendance marked!',$attendance);
        } else{
            $attendance = new Attendance;
            $attendance->user_id = $request->input('user_id');
            $attendance->type = 'check_out';
            $attendance->date = Carbon::now();
            $attendance->created_id = Auth::id();
            $attendance->save();
            return $this->processResponse('success',200,'Successfully checked out!',$attendance);
        }
    }

    public function markAbsent(Request $request){
        
        $request->validate([

            'start_date'=> 'required',
            'end_date'=> 'required',
            'user_id'=>'required',
        ]);
        
        $start_date = $request->input('start_date');
        
        $absent_count =0;
        while(Carbon::parse($start_date)->lte(Carbon::parse($request->input('end_date')))){

            if(!User::find($request->input('user_id'))->attendances->where('date',Carbon::parse($start_date))->count()){

                $attendance = new Attendance;
                $attendance->user_id = $request->input('user_id');
                $attendance->type = 'absent';
                $attendance->date = $start_date;
                $attendance->created_id = Auth::id();
                $attendance->save();

                $absent_count++;
            }

            $start_date = Carbon::parse($start_date)->addDay();
        }

        return $this->processResponse('success',200,$absent_count.' absent marked!',null);
    }

    public function userAttendance(Request $request){
       
        return  $this->processResponse('success',200,null,Auth::user()->isAttendanceMarked());
    }

    public function userAbsent(Request $request){

        return  $this->processResponse('success',200,null,Auth::user()->isAbsentForToday());
    }

    public function userCheckout(Request $request){

        return  $this->processResponse('success',200,null,Auth::user()->isCheckedOut());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->input('month')
            ? $month = Carbon::parse($request->input('month'))->toDateTimeString()
            : $month = Carbon::now()->startOfMonth()->toDateTimeString();
            
        $dates = array();
        $period = CarbonPeriod::create(Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth());
        foreach($period as $date)
        {
          $dates[] = $date->format('d-m-Y');
        }
            
        if(Auth::user()->isAdmin() || Auth::user()->isSuperAdmin()){

            $user = $request->input('user') ? $request->input('user') : "";

            $users = User::searchStrict('id', $user)->get();          
            
            foreach($users as $index=>$user){
                $attendances = array();
                foreach($dates as $date){
                    
                    $check_in = Attendance::where('user_id',$user->id)
                    ->where('date', '>=', Carbon::parse($date)->startOfDay())
                    ->where('date', '<=', Carbon::parse($date)->endOfDay())
                    ->where('type','check_in')
                    ->first();
                    
                    $check_out = Attendance::where('user_id',$user->id)
                    ->where('date', '>=', Carbon::parse($date)->startOfDay())
                    ->where('date', '<=', Carbon::parse($date)->endOfDay())
                    ->where('type','check_out')
                    ->first();

                    $absent = Attendance::where('user_id',$user->id)
                    ->where('date', '>=', Carbon::parse($date)->startOfDay())
                    ->where('date', '<=', Carbon::parse($date)->endOfDay())
                    ->where('type','absent')
                    ->first();
                    
                    $attendances[$date]['check_in'] = $check_in ? Carbon::parse($check_in->date)->toTimeString() : null;
                    $attendances[$date]['check_out'] = $check_out ?  Carbon::parse($check_out->date)->toTimeString() : null;
                    $attendances[$date]['absent'] = $absent ? Carbon::parse($absent->date)->toTimeString()  : null;
                }
                $users[$index]['attendances'] = $attendances;
            }

            

            return $this->processResponse('success',200,null,
                [
                    'users'=> $users,
                    'dates'=>$dates,
                    'attendances' => $attendances
                ]
            );
            
        }
        else{
            $users [] = Auth::user();
            
            foreach($users as $index=>$user){
                $attendances = array();
                foreach($dates as $date){
                    
                    $check_in = Attendance::where('user_id',$user->id)
                    ->where('date', '>=', Carbon::parse($date)->startOfDay())
                    ->where('date', '<=', Carbon::parse($date)->endOfDay())
                    ->where('type','check_in')
                    ->first();
                    
                    $check_out = Attendance::where('user_id',$user->id)
                    ->where('date', '>=', Carbon::parse($date)->startOfDay())
                    ->where('date', '<=', Carbon::parse($date)->endOfDay())
                    ->where('type','check_out')
                    ->first();

                    $absent = Attendance::where('user_id',$user->id)
                    ->where('date', '>=', Carbon::parse($date)->startOfDay())
                    ->where('date', '<=', Carbon::parse($date)->endOfDay())
                    ->where('type','absent')
                    ->first();
                    
                    $attendances[$date]['check_in'] = $check_in ? Carbon::parse($check_in->date)->toTimeString() : null;
                    $attendances[$date]['check_out'] = $check_out ?  Carbon::parse($check_out->date)->toTimeString() : null;
                    $attendances[$date]['absent'] = $absent ? Carbon::parse($absent->date)->toTimeString()  : null;
                }
                $users[$index]['attendances'] = $attendances;
            }

            return $this->processResponse('success',200,null,
                [
                    'users'=> $users,
                    'dates'=>$dates,
                    'attendances' => $attendances
                ]
            );
            

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
