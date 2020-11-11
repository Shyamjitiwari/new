<?php

namespace App\Http\Controllers;

use App\TaskClassType;
use Illuminate\Http\Request;

class TaskClassTypeController extends Controller
{

    public function getTaskClassType()
    {
        $taskClassType = TaskClassType::all();

        return response()->json(['task_class_types'=> $taskClassType,'status'=>'success'],200);
    }

}
