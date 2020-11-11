<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ActivityController extends Controller
{
    public function activities()
    {
        return view('cp.activities');
    }

    /**
     * Display all activities related to leads and login / logout
     * and filters accordingly
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $name = ($request->input('name')) ? $request->input('name') : '';
        $remarks = ($request->input('remarks')) ? $request->input('remarks') : '';

        $activities = Activity::where('activity_type', 'App\User')
            ->searchManyMorph('name', 'App\User', $name, 'activity')
            ->search('system_remark', $remarks)
            ->with('activity')
            ->orderBy('created_at', 'desc')
            ->paginate(Config::get('settings.pagination'));

        return $this->processResponse('activities', $activities, null, 'success', 200);
    }
}
