<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaskClassFrequency;

class TaskClassFrequencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher|admin');
    }

    public function getAllTaskClassFrequencies(){
        $frequencies = TaskClassFrequency::all();

        return response()->json(['taskClassFrequencies'=> $frequencies],200);
    }
}
