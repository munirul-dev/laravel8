<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted;
use App\Http\Requests\StoreComment;
use App\Http\Resources\Comment as CommentResource;
use App\Models\BlogPost;

class PostCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function index(BlogPost $post)
    {
        return CommentResource::collection($post->comments()->with('user')->get());
        // return $post->comments()->with('user')->get();
    }

    public function store(BlogPost $post, StoreComment $request)
    {
        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id,
        ]);

        // Mail::to($post->user)->send(
        //     new CommentPostedMarkdown($comment)
        // );

        // Mail::to($post->user)->queue(
        //     new CommentPostedMarkdown($comment)
        // );

        // $when = now()->addSeconds(5);
        // Mail::to($post->user)->later(
        //     $when,
        //     new CommentPostedMarkdown($comment)
        // );

        event(new CommentPosted($comment));
        return redirect()->back()->with('status', 'Comment was created!');
    }
}
