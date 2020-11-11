<?php

namespace App\Http\Controllers;

use App\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', UserGroup::class);

        $name = ($request->input('name')) ? $request->input('name') : '';
        $status = ($request->input('status') ? $request->input('status') : '');

        return $this->processResponse('success', 200, null,
            UserGroup::search('name',$name)
            ->searchStrict('status',$status)
            ->withCount('users')
            ->paginate(Config::get('settings.pagination')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', UserGroup::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', UserGroup::class);

        $request->validate([
            'name' => 'required|unique:user_groups,name',
        ]);

        $userGroup = new UserGroup;
        $userGroup->name = $request->input('name');
        $userGroup->status = 'active';
        $userGroup->created_id = Auth::user()->id;
        $userGroup->save();

        return $this->processResponse('success',200,'User Group created!',$userGroup);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function show(UserGroup $userGroup)
    {
        $this->authorize('view', $userGroup);

        return $this->processResponse('success',200,null,$userGroup);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(UserGroup $userGroup)
    {
        $this->authorize('update', $userGroup);

        return $this->processResponse('success',200,null,$userGroup);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserGroup $userGroup)
    {
        $this->authorize('update', $userGroup);

        $request->validate([
            'name' => 'required|unique:user_groups,name,'.$request->id,
        ]);

        $userGroup->name = $request->input('name');
        $userGroup->status = 'active';
        $userGroup->updated_id = Auth::user()->id;
        $userGroup->save();

        return $this->processResponse('success',200,'User Group updated!',$userGroup);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserGroup $userGroup)
    {
        $this->authorize('delete', $userGroup);

        if($userGroup->users->count() > 0)
        {
            return $this->processResponse('error',404,'Builder has linked users, cannot be deleted!',null);
        }

        $userGroup->delete();

        return $this->processResponse('success',200,'Builder deleted!',$userGroup);
    }
}
