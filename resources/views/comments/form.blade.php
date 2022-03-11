<div class="mb-2 mt-2">
    @auth
        <form action="{{ route('posts.comments.store', ['post' => $post->id]) }}" method="post">
            @csrf

            <div class="form-group">
                <textarea id="content" name="content" class="form-control">{{ old('content') }}</textarea>
            </div>

            <div>
                <button type="submit" value="Create" class="btn btn-primary">Add Comment</button>
            </div>
        </form>
    @else
        <p>Please <a href="{{ route('login') }}">login</a> to add a comment.</p>
    @endauth
</div>

<x-errors></x-errors>
