<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function categories()
    {
        $this->authorize('viewAny', Category::class);

        return view('cp.categories');
    }
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $this->authorize('viewAny', Category::class);
        if(Auth::user()->isSuperAdmin() || Auth::user()->isSuperAdmin())
        {
            $categories = Category::withCount('blogs')->paginate(Config::get('settings.pagination'));
        } else {
            $categories = Category::withCount('blogs')
                ->where('created_id', Auth::id())
                ->paginate(Config::get('settings.pagination'));
        }

        return $this->processResponse('categories', $categories,null,'success', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        if(!$request->input('id')) {

            $this->authorize('create', Category::class);

            $request->validate([
                'name' => 'required|unique:categories,name',
                'description' => 'required',
            ]);
            $message = 'Category created!';
        } else {

            $this->authorize('create', Category::find($request->input('id')));

            $request->validate([
                'name' => 'required|unique:categories,name,'.$request->input('id'),
                'description' => 'required',
            ]);
            $message = 'Category updated!';
        }

        DB::beginTransaction();

        $category = Category::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'name' => $request->input('name'),
                'slug' => !$request->input('id')
                ? $this->slugify($request->input('name'),'categories')
                : $this->slugify($request->input('slug'),'categories', $request->input('id')),
                'description' => $request->input('description'),
                'category_id' => $request->input('category_id'),
                'type' => 'blog',
                !$request->input('id') ? 'created_id' : 'updated_id' => Auth::id()
            ]);

        DB::commit();

        return $this->processResponse('category', $category, $message, 'success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        if($category->blogs()->count())
        {
            return $this->processResponse('data', null, 'Category has linked blogs, cannot be deleted!', 'error', 404);
        }
        $category->delete();
        return $this->processResponse('data', null, 'Category delete successfully!', 'success', 200);

    }
}
