<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ActivityController extends Controller
{
    /**
     * Display all activities related to leads and login / logout
     * and filters accordingly
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $name = ($request->input('name')) ? $request->input('name') : '';
        $remarks = ($request->input('remarks')) ? $request->input('remarks') : '';
        $creaed_at = ($request->input('created_at')) ? $request->input('created_at') : '';

        $activities = Activity::where('activity_type', 'App\User')
            ->searchManyMorph('name', 'App\User', $name, 'activity')
            ->search('system_remark', $remarks)
            ->search('created_at', $creaed_at)
            ->with('activity')
            ->orderBy('created_at', 'desc')
            ->paginate(Config::get('settings.pagination'));

        return $this->processResponse('success', 200, null, $activities);
    }
}
