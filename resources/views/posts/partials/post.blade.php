<h3 class="mb-0"><a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a></h3>

@if ($post->comments_count)
    <p class="mb-0">{{ $post->comments_count }} comments</p>
@else
    <p>No comments yet</p>
@endif

<div class="mb-4">
    <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
    <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" value="Delete" class="btn btn-danger">Delete</button>
    </form>
</div>
