<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function userPermissions()
    {
        $allPermissions = \App\Permission::all();

        $permissions = Auth::user()->role->permissions()->get();

        $permission = array();

        foreach($allPermissions as $j)
        {
            $permission[$j->key] = false;
        }

        foreach($permissions as $p)
        {
            if(array_key_exists($p->key,$permission))
            {
                $permission[$p->key] = true;
            }
        }

        // setting and sending role as key and role id pair
        $permission['role'] = Auth::user()->role_id;
        $permission['role_name'] = Auth::user()->role->name;

        return $this->processResponse('permissions', $permission, null, 'success', 200);
    }
}
