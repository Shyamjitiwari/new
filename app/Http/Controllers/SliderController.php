<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    public function sliders(){

        return view('cp.sliders');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //$this->authorize('viewAny', Slider::class);

        if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
        {
            $sliders = Slider::with(['images'])->paginate(Config::get('settings.pagination'));
        } else {
            $sliders = Slider::with(['images'])
                ->where('created_id', Auth::id())
                ->paginate(Config::get('settings.pagination'));
        }

        return $this->processResponse('sliders', $sliders,null,'success', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CRUDController $controller)
    {
        if(!$request->input('id')) {
            // $this->authorize('create', Slider::class);
 
             $request->validate([
                 'heading' => 'required|unique:sliders,heading',
             ]);
         } else {
            // $this->authorize('update', Slider::find($request->input('id')));
 
             $request->validate([
                 'heading' => 'required|unique:sliders,heading,'.$request->input('id'),
             ]);
         }
 
         DB::beginTransaction();
 
         $slider = Slider::updateOrCreate(
             ['id' => $request->input('id')],
             [
                 'heading' => $request->input('heading'),
                 'hyper_link' => $request->input('hyper_link'),
                 'description_line1' => $request->input('description_line1'),
                 'description_line2' => $request->input('description_line2'),
                 'description_line3' => $request->input('description_line3'),
                 'created_id'  => $request->input('created_id'),
                 'updated_id' => Auth::id(),
             ]);
 
             //Uploading & linking image here

            if($request->has('image_name')){
                foreach($request->input('image_name') as $file){
                    $controller->storeImage($file, $slider, 'sliders', false, true, true);
                }
            }
             
             
 
         DB::commit();
 
         return $this->processResponse('slider', $slider, null, 'success', 200);
    }

    public function deleteImage(Slider $slider, CRUDController $controller)
    {
        $controller->detachImageForSingleImageModels($slider);

        return $this->processResponse(null, null, 'Image deleted!', 'success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
         //$this->authorize('delete', $slider);

         $slider->delete();
 
         return $this->processResponse('data', null, 'Slider deleted successfully!', 'success', 200);
     
    }
}
