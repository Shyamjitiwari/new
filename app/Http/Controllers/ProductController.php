<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function products(){

        return view('cp.products');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //$this->authorize('viewAny', Product::class);

        if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
        {
            $products = Product::with(['category', 'brand', 'image'])->paginate(Config::get('settings.pagination'));
        } else {
            $products = Product::with(['category', 'brand', 'image'])
                ->where('created_id', Auth::id())
                ->paginate(Config::get('settings.pagination'));
        }

        return $this->processResponse('products', $products,null,'success', 200);
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
           // $this->authorize('create', Product::class);

            $request->validate([
                'name' => 'required|unique:products,name',
                'description' => 'required',
                'category_id' => 'required',
                'brand_id' => 'required',
                'created_id' => 'required'
            ]);
        } else {
            $this->authorize('update', Blog::find($request->input('id')));

            $request->validate([
                'name' => 'required|unique:products,name,'.$request->input('id'),
                'description' => 'required',
                'category_id' => 'required',
                'brand_id' => 'required',
                'created_id' => 'required'
            ]);
        }

        DB::beginTransaction();

        $product = Product::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'name' => $request->input('name'),
                'slug' => !$request->input('id')
                    ? $this->slugify($request->input('name'),'products')
                    : $this->slugify($request->input('slug'),'products', $request->input('id')),
                'description' => $request->input('description'),
                'category_id' => $request->input('category_id'),
                'brand_id' => $request->input('brand_id'),
                'meta_title' => $request->input('meta_title'),
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
                'created_id' => $request->input('created_id'),
                'updated_id' => Auth::id(),
            ]);

            //add all attributes
        $product->attributes()->sync(collect($request->input('attributes'))->pluck('id'));

            //Uploading & linking image here
            $request->input('image_name')
                ? $controller->storeImage($request->get('image_name'), $product, 'products', true, true, true)
                : null;

        DB::commit();

        return $this->processResponse('product', $product, null, 'success', 200);
    }

    public function deleteImage(Product $product, CRUDController $controller)
    {
        $controller->detachImageForSingleImageModels($product);

        return $this->processResponse(null, null, 'Image deleted!', 'success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //$this->authorize('delete', $product);

        $product->delete();
    }
}
