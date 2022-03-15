<div class="container">

    <x-card title="{{ __('Most Commented') }}" subtitle="{{ __('What people are currently talking about') }}">
        @slot('items')
            @forelse ($mostCommented as $post)
                <li class="list-group-item">
                    <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                    <p class="m-0 text-muted">{{ $post->comments_count }} {{ __('comments') }}</p>
                </li>
            @empty
                <li class="list-group-item">No posts found.</li>
            @endforelse
        @endslot
    </x-card>

    <x-card title="{{ __('Most Active') }}" subtitle="{{ __('Writers with most posts written') }}">
        @slot('items', collect($mostActive)->pluck('name'))
    </x-card>

    <x-card title="{{ __('Most Active Last Month') }}" subtitle="{{ __('Users with most posts written in the month') }}">
        @slot('items', collect($mostActiveLastMonth)->pluck('name'))
    </x-card>

</div>
