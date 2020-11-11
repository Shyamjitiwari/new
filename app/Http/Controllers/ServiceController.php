<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function services()
    {
       // $this->authorize('viewAny', Tag::class);

        return view('cp.services');
    }

    public function index()
    {
        //$this->authorize('viewAny', Service::class);

        if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
        {
            $services = Service::with(['tags', 'image'])->paginate(Config::get('settings.pagination'));
        } else {
            $services = Service::with([ 'tags', 'image'])
                ->where('created_id', Auth::id())
                ->paginate(Config::get('settings.pagination'));
        }

        return $this->processResponse('services', $services,null,'success', 200);
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
           // $this->authorize('create', Service::class);

            $request->validate([
                'name' => 'required|unique:services,name',
                'description' => 'required',
                'tags' => 'required',
            ]);
        } else {
           // $this->authorize('update', Service::find($request->input('id')));

            $request->validate([
                'name' => 'required|unique:services,name,'.$request->input('id'),
                'description' => 'required',
                'tags' => 'required',
            ]);
        }

        DB::beginTransaction();

        $service = Service::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'name' => $request->input('name'),
                'slug' => !$request->input('id')
                    ? $this->slugify($request->input('name'),'services')
                    : $this->slugify($request->input('slug'),'services', $request->input('id')),
                'description' => $request->input('description'),
                'meta_title' => $request->input('meta_title'),
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
                'updated_id' => Auth::id(),
            ]);

        // add all tags
        $service->tags()->sync(collect($request->input('tags'))->pluck('id'));

            //Uploading & linking image here
            $request->input('image_name')
                ? $controller->storeImage($request->get('image_name'), $service, 'services', true, true, true)
                : null;

        DB::commit();

        return $this->processResponse('service', $service, null, 'success', 200);
    }

    public function deleteImage(Service $service, CRUDController $controller)
    {
        $controller->detachImageForSingleImageModels($service);

        return $this->processResponse(null, null, 'Image deleted!', 'success', 200);
    }

    public function update(Request $request, Service $service)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        //$this->authorize('delete', $blog);

        $service->tags()->detach();
        $service->delete();

        return $this->processResponse('data', null, 'Service deleted successfully!', 'success', 200);
    }
}
