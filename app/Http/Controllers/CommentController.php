<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use App\Blog;
use App\Mail\CommentReceivedMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
        {
            $comments = Comment::paginate(Config::get('settings.pagination'));
        } else {
            $comments = Comment::where('created_id', Auth::id())
                ->paginate(Config::get('settings.pagination'));
        }

        return $this->processResponse('comments', $comments,null,'success', 200);
    }

    public function changeStatus(Comment $comment)
    {

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if($request->has('parent_id'))
        {
            $comment = Comment::find($request->parent_id);
            $blog  = $comment->commentable;
            $comment = $blog->comments()->create([

                'description' => $request->message,
                'status' => 'inactive',
                'name' => $request->name,
                'parent_id' => $request->parent_id,
            ]);
            Mail::to('gauu1001@gmail.com')->bcc('asklko2004@gmail.com')
            ->send(new CommentReceivedMail($comment,$blog));
        }
        else{
        $blog = Blog::find($request->blog_id);
        $comment = $blog->comments()->create([

            'description' => $request->message,
            'status' => 'inactive',
            'name' => $request->name,
        ]);

        Mail::to('gauu1001@gmail.com')->bcc('asklko2004@gmail.com')
        ->send(new CommentReceivedMail($comment,$blog));

        }
        return $this->processResponse('comment', $comment,null,'success', 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Comment $comment)
    {
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Comment $comment)
    {
        //$this->authorize('delete', $comment);
        foreach($comment->replies as $child){
            $child->delete();
        }

        $comment->delete();

        return $this->processResponse('data', null, 'Comment deleted successfully!', 'success', 200);
    }
}
