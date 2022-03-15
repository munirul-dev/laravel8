<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\CommentPosted;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComment;
use Illuminate\Http\Request;
use App\Http\Resources\Comment as CommentResource;
use App\Models\BlogPost;
use App\Models\Comment;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['show', 'store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BlogPost $post, Request $request)
    {
        $perPage = $request->per_page ?? 10;
        return CommentResource::collection($post->comments()->with('user')->paginate($perPage)->appends([
            'per_page' => $perPage,
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPost $post, StoreComment $request)
    {
        $this->authorize(Comment::class);
        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id,
        ]);

        event(new CommentPosted($comment));

        return new CommentPosted($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BlogPost $post, Comment $comment)
    {
        $this->authorize($comment);
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogPost $post, Comment $comment, StoreComment $request)
    {
        $this->authorize($comment);
        $comment->content = $request->content;
        $comment->save();
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogPost $post, Comment $comment)
    {
        $this->authorize($comment);
        $comment->delete();
        return response()->noContent();
    }
}
