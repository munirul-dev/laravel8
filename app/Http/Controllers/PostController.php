<?php

namespace App\Http\Controllers;

use App\Events\BlogPostPosted;
use App\Facades\CounterFacades;
use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    private $counter;

    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index', ['posts' => BlogPost::latestWithRelations()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('create', BlogPost::class);
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;
        $blogPost = BlogPost::create($validatedData);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');
            // Storage::putFileAs('thumbnails', $file, $blogPost->id . '.' . $file->guessExtension());
            $blogPost->image()->save(
                Image::make(['path' => $path])
            );
        }

        event(new BlogPostPosted($blogPost));
        $request->session()->flash('status', 'The blog post was created!');
        return redirect()->route('posts.show', ['post' => $blogPost->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blogPost = Cache::tags(['blog-post'])->remember("blog-post-{$id}", now()->addMinutes(60), function () use ($id) {
            return BlogPost::with('comments', 'tags', 'user', 'comments.user')->findOrFail($id);
        });

        return view('posts.show', [
            'post' => $blogPost,
            'counter' => CounterFacades::increment("blog-post-{$id}", ['blog-post']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        $this->authorize('update', $post);
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);
        $this->authorize('update', $post);
        $validated = $request->validated();
        $post->fill($validated);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');

            if ($post->image) {
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            } else {
                $post->image()->save(Image::make(['path' => $path]));
            }
        }

        $post->save();
        $request->session()->flash('status', 'Blog post was updated!');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);
        $this->authorize('delete', $post);
        $post->delete();
        session()->flash('status', 'Blog post was deleted!');
        return redirect()->route('posts.index');
    }
}
