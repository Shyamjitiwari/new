<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAll(Request $request)
    {
        return response()->json(
            [
                'data'=> ("App\\".Str::studly(Str::singular($request->input('table'))))::orderBy('name', 'asc')->get(),
                'message' => null,
                'status'=>'success'
            ],200);
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

        return response()->json(
            [
                'data'=> ("App\\" . Str::studly(Str::singular($table)))::where('is_deleted', '!=', 1)
                    ->orderBy($column, $order)
                    ->get(),
                'message' => null,
                'status'=>'success'
            ],200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllActiveFiltered(Request $request)
    {
        return response()->json(
            [
                'data'=> DB::table($request->input('table'))
                    ->select('id', $request->input('column'))
                    ->where('is_deleted', '!=', 1)
                    ->where($request->input('column'), 'like', '%' . $request->input('search') . '%')
                    ->get(),
                'message' => null,
                'status'=>'success'
            ],200);

    }

    public function uploadImage($image, $folder, $from_frontend = false)
    {
        $random_name = time();

        //if from blade
        if(!$from_frontend)
        {
            $image->getClientOriginalExtension() == 'jpeg' ? $extension = 'jpg' : $extension = $image->getClientOriginalExtension();
            $filename = $random_name . '.' . $image->getClientOriginalExtension();
        }
        else // if from vuejs
        {
            $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            $extension  = 'jpeg' ? $extension = 'jpg' : null;
            $filename = $random_name.'.' . $extension;
        }

        $image_parts = explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = public_path('images/' . $folder . '/' . $filename);

        file_put_contents($file, $image_base64);

        return $filename;
    }

    /**
     * @param $folder
     * @param $image
     */
    public function deleteExistingImage($folder, $image)
    {
        if($image !== 'default.png') {
            $filename = public_path() . '/images/' . $folder . '/' . $image;
            unlink($filename);
            ("App\\" . Str::studly(Str::singular($folder)))::where('image_name', $image)->update(['image_name' => 'default.png']);
        }
    }
}
