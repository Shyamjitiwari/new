<?php

namespace App\Http\Controllers;

use App\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
        {
            $galleries = Gallery::with(['images','category'])->get();
        } else {
            $galleries = Gallery::with(['images','category'])->where('created_id', Auth::id())->get();

        }

        foreach($galleries as $gallery){
            $media = array();
            foreach($gallery->images as $image){

                $media[] = [
                            'thumb'  => '/'.$image->folder.'/'.$image->thumbnail,
                            'src'    => '/images2/'.$image->folder.'/'.$image->name,
                            'caption'  => 'caption to display. receive <html> <b>tag</b>',
                        ];
            }
            $gallery['media'] = $media;
        }

        return $this->processResponse('galleries', $galleries,null,'success', 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request , CRUDController $controller)
    {
        $request->validate([
            'category' => 'required',
            'image_name'   => 'required',
        ]);


        if($request->has('image_name')){

            $files = $request->input('image_name');

            DB::beginTransaction();

            $gallery = Gallery::where('category_id',$request->input('category'))->first();
            
            if(!$gallery){
                $gallery = new Gallery;
                $gallery->category_id = $request->input('category');
                $gallery->status = 'Active';
                $gallery->created_id = Auth::id();
                $gallery->save();
            }

            foreach($files as $file){
                 $controller->storeImage($file, $gallery, 'galleries', false, true, true);
            }
            DB::commit();

            return $this->processResponse('gallery', $gallery, null, 'success', 200);
        }
    
        
        return $this->processResponse('gallery', null, null, 'success', 200);

    }

}
