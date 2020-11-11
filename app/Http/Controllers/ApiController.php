<?php

namespace App\Http\Controllers;

use App\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Api::class);

        $url = ($request->input('url')) ? $request->input('url') : '';
        $type = ($request->input('type')) ? $request->input('type') : '';
        $status = ($request->input('status') ? $request->input('status') : '');

        return $this->processResponse('success', 200, null,
            Api::with(['user_group'])
            ->searchStrict('url',$url)
            ->searchStrict('type',$type)
            ->searchStrict('status',$status)
            ->paginate(Config::get('settings.pagination')));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Api::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Api::class);

        $request->validate([
            'url' => 'required|unique:apis,url',
            'type'=> 'required',
        ]);

        $api = new Api();
        $api->url = $request->input('url');
        $api->type = $request->input('type');
        $api->key = $request->input('key')  ? $request->input('key') : null;
        $api->user_name = $request->input('user_name') ? $request->input('user_name') : null;
        $api->password = $request->input('password') ? $request->input('password') : null;
        $api->account_id = $request->input('account_id') ? $request->input('account_id') : null;
        $api->user_group_id = $request->input('user_group_id') ? $request->input('user_group_id') : null;
        $api->status = 'active';
        $api->created_id = Auth::user()->id;
        $api->save();

        return $this->processResponse('success',200,'API created!',$api);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Api  $api
     * @return \Illuminate\Http\Response
     */
    public function show(Api $api)
    {
        $this->authorize('view', $api);

        return $this->processResponse('success',200,null,$api);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Api  $api
     * @return \Illuminate\Http\Response
     */
    public function edit(Api $api)
    {
        $this->authorize('update', $api);

        return $this->processResponse('success',200,null,$api);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Api  $api
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Api $api)
    {
        $this->authorize('update', $api);

        $request->validate([
            'url' => 'required|unique:apis,url,'.$request->id,
            'type' => 'required'
        ]);

        $api->url = $request->input('url');
        $api->type = $request->input('type');
        $api->key = $request->input('key')  ? $request->input('key') : null;
        $api->user_name = $request->input('user_name') ? $request->input('user_name') : null;
        $api->password = $request->input('password') ? $request->input('password') : null;
        $api->account_id = $request->input('account_id') ? $request->input('account_id') : null;
        $api->user_group_id = $request->input('user_group_id') ? $request->input('user_group_id') : null;
        $api->status = 'active';
        $api->created_id = Auth::user()->id;
        $api->save();
        return $this->processResponse('success',200,'API updated!',$api);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Api  $api
     * @return \Illuminate\Http\Response
     */
    public function destroy(Api $api)
    {
        $this->authorize('delete', $api);

        $api->delete();

        return $this->processResponse('success',200,'Api deleted!',$api);
    }
}
