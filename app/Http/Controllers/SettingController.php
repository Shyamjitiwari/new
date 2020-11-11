<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Traits\ProcessResponse;

class SettingController extends Controller
{
    use ProcessResponse;

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $this->authorize('view', Setting::class);

        $settings = Setting::where('status', 1)->where('group', '<>', 'App Setting')->with('lists')->get();

        return $this->processResponse('success',200,null,$settings);
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
        $this->authorize('update', Setting::class);

        $setting = Setting::find($id);
        $setting->value = $request->value;
        $setting->save();

        return $this->processResponse('success',200,$setting->display_name. ' updated',$this->appSettings());

    }

}
