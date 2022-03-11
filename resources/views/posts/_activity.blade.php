<div class="container">

    <x-card title="Most Commented" subtitle="What people are currently talking about">
        @slot('items')
            @forelse ($mostCommented as $post)
                <li class="list-group-item">
                    <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                    <p class="m-0 text-muted">{{ $post->comments_count }} comments</p>
                </li>
            @empty
                <li class="list-group-item">No posts found.</li>
            @endforelse
        @endslot
    </x-card>

    <x-card title="Most Active" subtitle="Users with the most posts written">
        @slot('items', collect($mostActive)->pluck('name'))
    </x-card>

    <x-card title="Most Active Last Month" subtitle="Users with the most posts written last month">
        @slot('items', collect($mostActiveLastMonth)->pluck('name'))
    </x-card>

</div>
