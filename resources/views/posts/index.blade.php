@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
    <div class="row">

        <div class="col-8">
            @forelse ($posts as $key => $post)
                @include('posts.partials.post')
            @empty
                <h1>No posts found.</h1>
                <p>This is the content of the main page.</p>
            @endforelse
        </div>

        <div class="col-4">
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
                    @slot('items', collect($mostActiveLastMonths)->pluck('name'))
                </x-card>

            </div>
        </div>

    </div>
@endsection
