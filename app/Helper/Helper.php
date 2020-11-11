<?php

namespace App\Helper;

use App\Permission;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Helper
{
    public static function slugify($string, $table, $row_id = null)
    {
        $slug = Str::slug(Str::limit($string, 100), '-');
        if(!$row_id){
            //check if slug exists
            $isDuplicate = DB::table($table)->where('slug', $slug)->count();
        } else {
            //check if slug exists except for the current row
            $isDuplicate = DB::table($table)->where('slug', $slug)->where('id', '!=', $row_id)->count();
        }

        while ($isDuplicate > 0)
        {
            $slug = Str::slug($string, '-') . '-' . Str::random(3) . '-' . Str::random(3);
            $isDuplicate = DB::table($table)->where('slug', $slug)->count();
        }

        return Str::lower($slug);
    }

    public static function userPermissions($id)
    {
        $allPermissions = Permission::all()->pluck('key');
        $user = User::find($id);
        $permission = array();

        foreach($allPermissions as $j)
        {
            $permission[$j] = false;
        }

        foreach($allPermissions as $index => $p)
        {
            $x = explode('-', $p);
            $perform = $x[0];
            $model = Str::studly(Str::singular($x[1]));
            $check = ['create', 'read'];

            if (in_array($perform, $check) && $user->can($perform, $model.'::class'))
            {
                $permission[$p] = true;
            }
        }

        return $permission;
    }
}
