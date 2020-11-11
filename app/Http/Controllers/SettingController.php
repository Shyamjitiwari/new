<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Traits\ProcessResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function settings()
    {
        return view('cp.settings');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $s = Setting::where('status', 1)->where('group', '<>', 'App Setting')->with('lists')->get();

        $settings = [];

        foreach($s as $ss)
        {
            $settings[$ss->group][] = $ss;
        }

        return $this->processResponse('settings', $settings, null, 'success',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::find($id);
        $setting->value = $request->value;
        $setting->save();

        return $this->processResponse('data', $this->appSettings(), $setting->display_name. ' updated', 'success',200);

    }
}
