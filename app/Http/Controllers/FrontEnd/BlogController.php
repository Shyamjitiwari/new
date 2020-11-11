<?php

namespace App\Http\Controllers\FrontEnd;

use App\Blog;
use App\Category;
use App\Helper\LogActivity;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        LogActivity::add(null, 'blog-index');

        $categories = Category::active()->get();
        $tags = Tag::active()->get();
        $blogs = Blog::active()->orderBy('created_at', 'desc')->with(['category', 'tags', 'image', 'created_by','activeComments'])->paginate(6);
        return view('frontend.blogs.index')->withBlogs($blogs)->withCategories($categories)->withTags($tags);
    }

    /**
     * Display the specified resource.
     *
     * @param Blog $blog
     * @return Application|Factory|View
     */
    public function show($slug)
    {
        $blog = Blog::active()->where('slug', $slug)->with('activeComments.replies')->first();
        abort_if(!$blog, 404);
        LogActivity::add(null, $blog->name);

        return view('frontend.blogs.show')->withBlog($blog);
    }

}
