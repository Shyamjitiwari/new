<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function brands(){
        return view('cp.brands');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $this->authorize('viewAny', Brand::class);

        if(Auth::user()->isSuperAdmin() || Auth::user()->isSuperAdmin())
        {
            $brands = Brand::with(['image'])->paginate(Config::get('settings.pagination'));
        } else {
            $brands = Brand::with(['image'])
                ->where('created_id', Auth::id())
                ->paginate(Config::get('settings.pagination'));
        }

        return $this->processResponse('brands', $brands,null,'success', 200);
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
           // $this->authorize('create', Brand::class);

            $request->validate([
                'name' => 'required|unique:brands,name',
                'description' => 'required',
                'created_id' => 'required'
            ]);
        } else {
            //$this->authorize('update', Brand::find($request->input('id')));

            $request->validate([
                'name' => 'required|unique:brands,name,'.$request->input('id'),
                'description' => 'required',
                'created_id' => 'required'
            ]);
        }

        DB::beginTransaction();

        $brand = Brand::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'name' => $request->input('name'),
                'slug' => !$request->input('id')
                    ? $this->slugify($request->input('name'),'brands')
                    : $this->slugify($request->input('slug'),'brands', $request->input('id')),
                'description' => $request->input('description'),
                'meta_title' => $request->input('meta_title'),
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
                'created_id' => $request->input('created_id'),
                'updated_id' => Auth::id(),
            ]);


            //Uploading & linking image here
            $request->input('image_name')
                ? $controller->storeImage($request->get('image_name'), $brand, 'brands', true, true, true)
                : null;

        DB::commit();

        return $this->processResponse('brand', $brand, null, 'success', 200);
    }

    public function deleteImage(Brand $brand, CRUDController $controller)
    {
        $controller->detachImageForSingleImageModels($brand);

        return $this->processResponse(null, null, 'Image deleted!', 'success', 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        //$this->authorize('delete', $brand);

        $brand->delete();

        return $this->processResponse('data', null, 'Brand delete successfully!', 'success', 200);
    }
}
