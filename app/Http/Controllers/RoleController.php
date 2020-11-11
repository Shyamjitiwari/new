<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Helper;

class RoleController extends Controller
{
    public function roles()
    {
        return view('cp.roles');
    }
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $roles = Role::with(['users', 'permissions'])->paginate(10);

        return $this->processResponse('roles', $roles,null,'success', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        if(!$request->input('id')) {
            $request->validate([
                'name' => 'required|unique:roles,name',
                'permissions' => 'required',
            ]);
            $message = 'Role created!';
        } else {
            $request->validate([
                'name' => 'required|unique:roles,name,'.$request->input('id'),
                'permissions' => 'required',
            ]);
            $message = 'Role updated!';
        }

        DB::beginTransaction();

        $role = Role::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'name' => $request->input('name'),
            ]);

        //sync permissions to roles
        $role->permissions()->sync(collect($request->input('permissions'))->pluck('id'));

        DB::commit();

        return $this->processResponse('role', $role, $message, 'success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function destroy(Role $role)
    {
        if($role->users()->count())
        {
            return $this->processResponse('data', null, 'Role has linked users, cannot be deleted!', 'error', 404);
        }
        $role->delete();
        return $this->processResponse('data', null, 'Role delete successfully!', 'success', 200);

    }
}
