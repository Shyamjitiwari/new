<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Helper;

class BlogController extends Controller
{
    public function blogs()
    {
        $this->authorize('viewAny', Blog::class);

        return view('cp.blogs');
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $this->authorize('viewAny', Blog::class);

        if(Auth::user()->isSuperAdmin() || Auth::user()->isSuperAdmin())
        {
            $blogs = Blog::with(['category', 'tags', 'image'])->paginate(Config::get('settings.pagination'));
        } else {
            $blogs = Blog::with(['category', 'tags', 'image'])
                ->where('created_id', Auth::id())
                ->paginate(Config::get('settings.pagination'));
        }

        return $this->processResponse('blogs', $blogs,null,'success', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request, CRUDController $controller)
    {
        if(!$request->input('id')) {
            $this->authorize('create', Blog::class);

            $request->validate([
                'name' => 'required|unique:blogs,name',
                'description' => 'required',
                'category_id' => 'required',
                'tags' => 'required',
                'created_id' => 'required'
            ]);
        } else {
            $this->authorize('update', Blog::find($request->input('id')));

            $request->validate([
                'name' => 'required|unique:blogs,name,'.$request->input('id'),
                'description' => 'required',
                'category_id' => 'required',
                'tags' => 'required',
                'created_id' => 'required'
            ]);
        }

        DB::beginTransaction();

        $blog = Blog::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'name' => $request->input('name'),
                'slug' => !$request->input('id')
                    ? $this->slugify($request->input('name'),'blogs')
                    : $this->slugify($request->input('slug'),'blogs', $request->input('id')),
                'description' => $request->input('description'),
                'category_id' => $request->input('category_id'),
                'meta_title' => $request->input('meta_title'),
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
                'read_time' => $request->input('read_time'),
                'created_id' => $request->input('created_id'),
                'created_at' => $request->input('created_at'),
                'updated_id' => Auth::id(),
            ]);

        // add all tags
        $blog->tags()->sync(collect($request->input('tags'))->pluck('id'));

            //Uploading & linking image here
            $request->input('image_name')
                ? $controller->storeImage($request->get('image_name'), $blog, 'blogs', true, true, true)
                : null;

        DB::commit();

        return $this->processResponse('blog', $blog, null, 'success', 200);
    }

    public function deleteImage(Blog $blog, CRUDController $controller)
    {
        $controller->detachImageForSingleImageModels($blog);

        return $this->processResponse(null, null, 'Image deleted!', 'success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Blog $blog)
    {
        $this->authorize('delete', $blog);

        $blog->tags()->detach();
        $blog->delete();

        return $this->processResponse('data', null, 'Blog delete successfully!', 'success', 200);
    }
}
