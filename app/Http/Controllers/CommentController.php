<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Helper\LogActivity;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Comment::class);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Comment::class);
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
        $this->authorize('create', Comment::class);

        $request->validate([
            'comment' => 'required'
        ]);

        // Converting table name to fully qualified model name
        $lead = ("App\\".Str::studly(Str::singular($request->input('type'))))::find($request->input('id'));

        $comment = $lead->comments()->create([
            'comment' => $request->input('comment'),
            'created_id' => Auth::user()->id,
            'parent_id' => $request->input('parent_id')
        ]);

        if($request->input('parent_id'))
        {
            LogActivity::add(Auth::user(), 'ActivityLabels::_LEAD_COMMENT_REPLY_ADDED');
        } else {
            LogActivity::add(Auth::user(), 'ActivityLabels::_LEAD_COMMENT_ADDED');
        }

        return $this->processResponse('success', 200, 'Comment added!', $comment);
    }

    /**
     * Display the specified resource.
     *
     * @param Comment $comment
     * @return void
     * @throws AuthorizationException
     */
    public function show(Comment $comment)
    {
        $this->authorize('view', $comment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Comment $comment
     * @return void
     * @throws AuthorizationException
     */
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Comment $comment
     * @return void
     * @throws AuthorizationException
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $comment
     * @return void
     * @throws AuthorizationException
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
    }
}
