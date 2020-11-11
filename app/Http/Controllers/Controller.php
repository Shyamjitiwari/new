<?php

namespace App\Http\Controllers;

use App\Setting;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as Photo;
use App\Traits\ProcessResponse;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ProcessResponse;

    /**
     * @var int|mixed
     */
    protected $pagination = 10;
    /**
     * @var array
     */
    protected $app = [];

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->appSettings();
        $this->pagination = Config::get('settings.pagination');
    }

    /**
     *
     */
    public function appSettings()
    {
        $settings = Setting::all();
        foreach($settings as $setting)
        {
            $this->app[$setting->key] = $setting->value;
        }

        $this->processResponse('success',200,null,$this->app);
    }

    // public function updateSettings($key, $value)
    // {
    //     $setting = Setting::where('key', $key)->first();
    //     $setting->value = $value;
    //     $setting->save();
    // }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllActiveFiltered(Request $request)
    {
        return $this->processResponse(
            'success', 200, null,
            DB::table($request->input('table'))
            ->select('id', $request->input('column'))
            ->where('status', '!=', 'inactive')
            ->where($request->input('column'), 'like', '%' . $request->input('search') . '%')
            ->get()
        );
    }

    /**
     * @param $table
     * @return JsonResponse
     */
    public function getAll($table)
    {
        return $this->processResponse('success',200,null,
        ("App\\".Str::studly(Str::singular($table)))::orderBy('name', 'asc')->get());
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

        return $this->processResponse('success', 200, null, ("App\\" . Str::studly(Str::singular($table)))::where('status', '!=', 'inactive')->orderBy($column, $order)->get());
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

        return $this->processResponse('success',200,$message, null);
    }

    /**
     * @param $i
     * @param $month
     * @param $year
     * @return string
     * @throws Exception
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
    public function slugify($string, $table)
    {
        $slug = Str::slug(Str::limit($string, 30), '-');

        $isDuplicate = DB::table($table)->where('slug', $slug)->count();

        while ($isDuplicate > 0)
        {
            $slug = Str::slug($string, '-') . '-' . Str::random(3) . '-' . Str::random(3);
            $isDuplicate = DB::table($table)->where('slug', $slug)->count();
        }

        return Str::lower($slug);
    }

    /**
     * @param $image
     * @param $folder
     * @param bool $thumbnail
     * @param bool $from_frontend
     * @return mixed
     */
    public function uploadImage($image, $folder, $thumbnail = false, $from_frontend = false)
    {
        $random_name = time();

        if(!$from_frontend)
        {
            $filename = $random_name . '.' . $image->getClientOriginalExtension();
        }
        else
        {
            $filename = $random_name.'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        }

        Photo::make($image)->save(public_path('/images/' . $folder . '/' . $filename));

        if($thumbnail)
        {
            $filename_thumb = $random_name . '_thumb' . '.' . $image->getClientOriginalExtension();

            Photo::make($image)->crop(100, 100, 25, 25)->save(public_path('/images/' . $folder . '/' . $filename_thumb));

            $images['filename_thumb'] = $filename_thumb;
        }

        $images['filename'] = $filename;

        return $images;
    }


    /**
     * @param Request $request
     */
    public function deleteImage(Request $request)
    {
        $folder = $request->input('folder');
        $image = $request->input('image');
        $filename = public_path() . '/images/' . $folder . '/' . $image;
        unlink($filename);

        ("App\\".Str::studly(Str::singular($folder)))::where('image_name', $image)->update(['image_name' => null]);
    }

    /**
     * @param $folder
     * @param $image
     */
    public function deleteExistingImage($folder, $image)
    {
        $filename = public_path() . '/images/' . $folder . '/' . $image;
        unlink($filename);
        ("App\\".Str::studly(Str::singular($folder)))::where('image_name', $image)->update(['image_name' => null]);
    }
}
