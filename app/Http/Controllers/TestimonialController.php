<?php

namespace App\Http\Controllers;

use App\Testimonial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{

    public function testimonials()
    {
       // $this->authorize('viewAny', Testimonial::class);

        return view('cp.testimonials');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$this->authorize('viewAny', Testimonial::class);

        if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
        {
            $testimonials = Testimonial::with(['image'])->paginate(Config::get('settings.pagination'));
        } else {
            $testimonials = Testimonial::with(['image'])
                ->where('created_id', Auth::id())
                ->paginate(Config::get('settings.pagination'));
        }

        return $this->processResponse('testimonials', $testimonials,null,'success', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , CRUDController $controller)
    {
        if(!$request->input('id')) {
          //  $this->authorize('create', Testimonial::class);

            $request->validate([
                'name'          => 'required',
                'company'       => 'required',
                'designation'   => 'required',
                'description'   => 'required',

            ]);

        } else {
           // $this->authorize('update', Testimonial::find($request->input('id')));

            $request->validate([
                'name'          => 'required',
                'company'       => 'required',
                'designation'   => 'required',
                'description'   => 'required',

            ]);
        }

        DB::beginTransaction();

        $testimonial = Testimonial::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'name' => $request->input('name'),
                'company' => $request->input('company'),
                'designation' => $request->input('designation'),
                'description' => $request->input('description'),
                'created_id' => Auth::id(),
                'updated_id' => Auth::id(),
            ]);


            //Uploading & linking image here
            $request->input('image')
                ? $controller->storeImage($request->get('image'), $testimonial, 'testimonials', true, true, true)
                : null;

        DB::commit();

        return $this->processResponse('testimonial', $testimonial, null, 'success', 200);

    }

    public function deleteImage(Testimonial $testimonial, CRUDController $controller)
    {
        $controller->detachImageForSingleImageModels($testimonial);

        return $this->processResponse(null, null, 'Image deleted!', 'success', 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $testimonial)
    {
       // $this->authorize('delete', $testimonial);

        $testimonial->delete();

        return $this->processResponse('data', null, 'Testimonial deleted successfully!', 'success', 200);
    }
}
