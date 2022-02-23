@if ($loop->even)
    <div>{{ $key + 1 }}. {{ $post->title }}</div>
@else
    <div style="background-color: silver;">{{ $key + 1 }}. {{ $post->title }}</div>
@endif

<div>
    <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" value="Delete">Delete</button>
    </form>
</div>
