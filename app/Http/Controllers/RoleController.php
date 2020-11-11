<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Role::class);

        $name = ($request->name) ? $request->name : '';
        $status = ($request->status ? $request->status : '');

        $role = Role::search('name',$name)
            ->searchStrict('status',$status)
            ->with(['permissions', 'users'])
            ->paginate(Config::get('settings.pagination'));

        return $this->processResponse('success',200,null, $role);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        return $this->processResponse('success',200,null,null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        if($request->has('id'))
        {
            //editing role
            $role = Role::find($request->id);
            $this->authorize('update', $role);
            $message = 'Role Updated!';

            $request->validate([
                'name' => 'required|unique:roles,name, '.$request->id,
            ]);

        } else {
            //creating role
            $this->authorize('create', Role::class);
            $message = 'Role Created!';

            $request->validate([
                'name' => 'required|unique:roles,name',
            ]);
        }



        DB::beginTransaction();

        $role = Role::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'status' => 'active',
                ($request->id) ? 'updated_id' : 'created_id' => Auth::user()->id,
            ]
        );

        if($request->has('permissions'))
        {
            if($request->has('id')){
                $role->permissions()->detach();
            }
            foreach($request->permissions as $permission) {
                $role->permissions()->attach($permission['id']);
            }
        }

        DB::commit();

        return $this->processResponse('success',200,$message,$role);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show($id)
    {
        $role = Role::with(['users', 'permissions'])->find($id);

        $this->authorize('view', $role);

        return $this->processResponse('success',200,null,$role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);

        $this->authorize('update', $role);

        return $this->processResponse('success',200,null,$role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return void
     */
    public function update(Request $request, $id)
    {
//        $role = Role::find($id);
//
//        $this->authorize('update', $role);
//
//        $request->validate([
//            'name' => 'required|unique:roles,name,' . $id
//        ]);
//
//        $role->name = $request->name;
//        $role->updated_id = Auth::user()->id;
//        $role->save();
//
//        if($request->permissions) {
//            $role->permissions()->detach();
//            foreach($request->permissions as $permission) {
//                $role->permissions()->sync($permission['id']);
//            }
//        } else {
//            $role->permissions()->detach();
//        }
//
//        return $this->processResponse('success',200,'Role updated!',$role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        $role = Role::find($id);

        $this->authorize('delete', $role);

        if($role->users->count() > 0)
        {
            return $this->processResponse('success',404,'Role has been assigned to users, cannot be deleted!',null);
        }

        DB::beginTransaction();

        $role->delete();
        $role->permissions()->detach();
        $role->users()->delete();

        DB::commit();

        return $this->processResponse('success',200,'Role deleted!',$role);
    }
}
