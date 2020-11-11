<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as Photo;

class CRUDController extends Controller
{
    public function storeImage($image, $model, $folder, $primary = false, $from_frontend = false, $removeAllLinkedImages = false, $image_id = null)
    {
        $random_name = time();

        if(!$from_frontend) {
            $filename = $random_name . '.' . $image->getClientOriginalExtension();
            $thumbnail = $random_name. '_thumb' . '.' . $image->getClientOriginalExtension();
        } else {
            $filename = $random_name.'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            $thumbnail = $random_name. '_thumb' .'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        }

        Photo::make($image)->save(public_path('/images2/' . $folder . '/' . $filename));

        Photo::make($image)->crop(100, 100, 25, 25)
                           ->save(public_path('/images2/' . $folder . '/' . $thumbnail));

        $image = Image::updateOrCreate(
            ['id' => $image_id],
            [
                'name' => $filename,
                'thumbnail' => $thumbnail,
                'folder' => $folder,
            ]
        );

        if(!$primary) {
            $model->images()->attach($image);
        } else {
            $removeAllLinkedImages ? $model->images()->detach() : null;
            $model->images()->attach($image, ['primary' => true]);
        }
    }

    public function detachImageForSingleImageModels($model)
    {
        $model->images()->detach();
    }

    public function deleteExistingImage($folder, $image)
    {
        $filename = public_path() . '/images/' . $folder . '/' . $image;
        unlink($filename);
        ("App\\".Str::studly(Str::singular($folder)))::where('image_name', $image)->update(['image_name' => null]);
    }

    public function deleteImage(Request $request)
    {
        $folder = $request->input('folder');
        $image = $request->input('image');
        $filename = public_path() . '/images/' . $folder . '/' . $image;
        unlink($filename);

        ("App\\".Str::studly(Str::singular($folder)))::where('image_name', $image)->update(['image_name' => null]);
    }

}
