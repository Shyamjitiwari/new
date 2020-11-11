<?php

namespace App\Http\Controllers;

use App\Helper\LogActivity;
use App\Http\Controllers\Auth\LoginController;
use App\Permission;
use App\Setting;
use App\Traits\ProcessResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ProcessResponse;

    protected $pagination = 10;
    protected $app = [];

    public function __construct()
    {
        $this->appSettings();
        $this->pagination = Config::get('settings.pagination');
    }

    public function appSettings()
    {
        $settings = Setting::all();
        foreach($settings as $setting)
        {
            $this->app[$setting->key] = $setting->value;
        }

        $this->processResponse('data', $this->app, null,'success',200);
    }

    public function userPermissions()
    {
        $allPermissions = Permission::all();

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

        return $this->processResponse('permissions',$permission, null, 'success', 200 );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllActiveFiltered(Request $request)
    {
        return $this->processResponse(
            'data',
            DB::table($request->input('table'))
                ->select('id', $request->input('column'))
                ->where('status', '!=', 'inactive')
                ->where($request->input('column'), 'like', '%' . $request->input('search') . '%')
                ->get(),
            null, 'success', 200
        );
    }

    /**
     * @param $table
     * @return JsonResponse
     */
    public function getAll($table)
    {
        return $this->processResponse('data', ("App\\".Str::studly(Str::singular($table)))::orderBy('name', 'asc')->get(),
            null,
            'success',
            200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllActive(Request $request)
    {
        $table = $request->input('table');
        $column = ($request->has('column')) ? $request->input('column') : 'name';
        $order = ($request->has('order')) ? $request->input('order') : 'asc';

        return $this->processResponse('data', ("App\\" . Str::studly(Str::singular($table)))::where('status', '!=', 'inactive')->orderBy($column, $order)->get(), null, 'success', 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function statusChange(Request $request)
    {
        $model = Str::studly(Str::singular($request->input('table')));
        $item = ("App\\".$model)::find($request->input('id'));

        if ($item->status == 'active')
        {
            $status = 'inactive';
            $message = $model. ' deactivated';
        } else {
            $status = 'active';
            $message = $model. ' activated';
        }

        ("App\\".$model)::where('id', $request->input('id'))->update(['status' => $status]);
        return $this->processResponse('data', null, $message, 'success',200);
    }

    /**
     * @param $i //time
     * @param $month
     * @param $year
     * @return string
     */
    static function getCurrentDate($i, $month, $year)
    {
        $day = new \Carbon\Carbon();
        $date = $day->setDate($year, $month, $i)->toDateString();
        return $date;
    }

    /**
     * @param $string
     * @param $table
     * @return string
     */
    public function slugify($string, $table, $row_id = null)
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

}
