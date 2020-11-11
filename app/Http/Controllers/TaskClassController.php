<?php

namespace App\Http\Controllers;

use App\Age;
use App\TaskClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskClassController extends Controller
{
    public function index()
    {
        $taskClasses = TaskClass::where('is_deleted',0)
            ->with(['ages','teacher','topics', 'task_class_type', 'students'])
            ->get();

        return response()->json(['task_classes'=> $taskClasses,'status'=>'success'],200);
    }

    public function taskClassProfile()
    {
        return view('task_class.admin_class_profile');
    }

    public function taskClassProfileShow($id)
    {
        $taskClass = TaskClass::with(['ages','teacher','students','topics', 'task_class_type', 'students','location', 'task_class_type'])->find($id);
        return view('task_class.admin_class_profile_show')->withTaskClass($taskClass);
    }

    public function getTaskClass($id)
    {
        $taskClass = TaskClass::with(['ages','teacher','students','topics', 'task_class_type', 'students', 'location', 'task_class_type'])->find($id);

        return response()->json(['task_class'=> $taskClass,'status'=>'success'],200);
    }

    public function getAges()
    {
        $ages = Age::all();

        return response()->json(['ages'=> $ages,'status'=>'success'],200);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        $taskClass = TaskClass::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'name' => $request->input('name'),
                'location_id' => $request->input('location_id'),
                'is_free_session' => $request->input('is_free_session'),
                'recurring' => $request->input('recurring'),
                'task_class_type_id' => $request->input('task_class_type_id'),
                'starts_at' => $request->input('starts_at'),
                'ends_at' => $request->input('ends_at'),
            ]
        );

        $taskClass->teacher()->sync($request->input('teacher_id'));
        $taskClass->topics()->sync($request->input('topics'));
        $taskClass->ages()->sync($request->input('ages'));
        DB::commit();

        return response()->json(['task_class'=> null, 'message' => 'Task Class updated successfully' ,'status'=>'success'],200);
    }

    public function updateData(Request $request)
    {
        if($request->input('type') == 'same')
        {
            TaskClass::where('id', $request->input('id'))->update([
                $request->input('key') => $request->input('value')
            ]);

            $message = title_case($request->input('msg')) . ' has been updated!';
        } else {
            $taskClass = TaskClass::find($request->input('id'));

            if($taskClass->teacher->count())
            {
                $taskClass->teacher()->detach([$taskClass->teacher->first()->id]);
            }

            $taskClass->teacher()->attach([$request->input('value')]);

            $message = title_case($request->input('msg')) . ' has been updated!';
        }

        return response()->json(['data'=> null, 'message' => $message ,'status'=>'success'],200);
    }

    public function destroy($id)
    {
        $task_class = TaskClass::find($id);

        DB::beginTransaction();

        $task_class->topics()->detach();
        $task_class->ages()->detach();
        $task_class->users()->detach();
        $task_class->delete();

        DB::commit();

    }
}
