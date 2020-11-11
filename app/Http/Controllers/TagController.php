<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function tags()
    {
        $this->authorize('viewAny', Tag::class);

        return view('cp.tags');
    }
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $this->authorize('viewAny', Tag::class);

        if(Auth::user()->isSuperAdmin() || Auth::user()->isSuperAdmin())
        {
            $tags = Tag::withCount('blogs')->paginate(Config::get('settings.pagination'));
        } else {
            $tags = Tag::withCount('blogs')
                ->where('created_id', Auth::id())
                ->paginate(Config::get('settings.pagination'));
        }



        return $this->processResponse('tags', $tags,null,'success', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        if(!$request->input('id')) {
            $this->authorize('create', Tag::class);

            $request->validate([
                'name' => 'required|unique:tags,name',
                'description' => 'required',
            ]);
            $message = 'Tag created!';
        } else {
            $this->authorize('create', Tag::find($request->input('id')));

            $request->validate([
                'name' => 'required|unique:tags,name,'.$request->input('id'),
                'description' => 'required',
            ]);
            $message = 'Tag updated!';
        }

        DB::beginTransaction();

        $tag = Tag::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'name' => $request->input('name'),
                'slug' => !$request->input('id')
                ? $this->slugify($request->input('name'),'tags')
                : $this->slugify($request->input('slug'),'tags', $request->input('id')),
                'description' => $request->input('description'),
                'type' => 'blog',
                !$request->input('id') ? 'created_id' : 'updated_id' => Auth::id()
            ]);

        if($request->get('image_name'))
        {
            //Saving image here
            $file_name = $this->uploadImage($request->get('image_name'), 'users', false, true);

            $tag->image_name = $file_name['filename'];
            $tag->save();
        }

        DB::commit();

        return $this->processResponse('tag', $tag, $message, 'success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $tag
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);

        if($tag->blogs()->count())
        {
            return $this->processResponse('data', null, 'Tag has linked blogs, cannot be deleted!', 'error', 404);
        }
        $tag->delete();
        return $this->processResponse('data', null, 'Tag delete successfully!', 'success', 200);

    }
}
