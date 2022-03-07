@if ($post->trashed())
    <del>
@endif
<h3 class="mb-0">
    <a class="{{ $post->trashed() ? 'text-muted' : '' }}" href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
</h3>
@if ($post->trashed())
    </del>
@endif

<x-updated date="{{ $post->created_at->diffForHumans() }}" name="{{ $post->user->name }}"></x-updated>

@if ($post->comments_count)
    <p>{{ $post->comments_count }} comments</p>
@else
    <p>No comments yet</p>
@endif

<div class="mb-4">
    @can('update', $post)
        <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
    @endcan

    @unless($post->trashed())
        @can('delete', $post)
            <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" value="Delete" class="btn btn-danger">Delete</button>
            </form>
        @endcan
    @endunless
</div>
