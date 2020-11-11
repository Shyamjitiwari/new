<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function pages()
    {
        return view('cp.pages');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //$this->authorize('viewAny', Page::class);

        if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
        {
            $pages = Page::with(['image'])->paginate(Config::get('settings.pagination'));
        } else {
            $pages = Blog::with(['image'])
                ->where('created_id', Auth::id())
                ->paginate(Config::get('settings.pagination'));
        }

        return $this->processResponse('pages', $pages,null,'success', 200);
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
           // $this->authorize('create', Page::class);

            $request->validate([
                'name' => 'required|unique:pages,name',
                'description' => 'required',
                'created_id' => 'required'
            ]);
        } else {
           // $this->authorize('update', Page::find($request->input('id')));

            $request->validate([
                'name' => 'required|unique:pages,name,'.$request->input('id'),
                'description' => 'required',
                'created_id' => 'required'
            ]);
        }

        DB::beginTransaction();

        $page = Page::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'name' => $request->input('name'),
                'slug' => !$request->input('id')
                    ? $this->slugify($request->input('name'),'pages')
                    : $this->slugify($request->input('slug'),'pages', $request->input('id')),
                'description' => $request->input('description'),
                'meta_title' => $request->input('meta_title'),
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
                'created_id' => $request->input('created_id'),
                'updated_id' => Auth::id(),
            ]);

            //Uploading & linking image here
            $request->input('image_name')
                ? $controller->storeImage($request->get('image_name'), $page, 'pages', true, true, true)
                : null;

        DB::commit();

        return $this->processResponse('page', $page, null, 'success', 200);
    }

    public function deleteImage(Page $page, CRUDController $controller)
    {
        $controller->detachImageForSingleImageModels($page);

        return $this->processResponse(null, null, 'Image deleted!', 'success', 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
       // $this->authorize('delete', $page);

        $page->delete();

        return $this->processResponse('data', null, 'Page delete successfully!', 'success', 200);
    }
}
