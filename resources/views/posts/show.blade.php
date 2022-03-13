@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="row">

        <div class="col-8">

            @if ($post->image)
                <div style="background-image: url('{{ $post->image->url() }}'); min-height: 500px; color: white; text-align:center; background-attachment: fixed; background-size: cover; background-position: center;">
                    <h1 style="padding-top: 100ox; text-shadow: 1px 2px black;">
                        {{ $post->title }}
                        <x-badge type="success" :show="now()->diffInMinutes($post->created_at) < 5">
                            New!
                        </x-badge>
                    </h1>
                </div>
            @else
                <h1>
                    {{ $post->title }}
                    <x-badge type="success" :show="now()->diffInMinutes($post->created_at) < 5">
                        New!
                    </x-badge>
                </h1>
            @endif

            <p>{{ $post->content }}</p>
            <x-updated :date="$post->created_at->diffForHumans()" :name="$post->user->name"></x-updated>
            <x-updated :date="$post->updated_at->diffForHumans()">Updated</x-updated>
            <x-tags :tags="$post->tags"></x-tags>

            <p>Currently read by {{ $counter }} people</p>

            <h4>Comments</h4>

            <x-commentForm :route="route('posts.comments.store', ['post' => $post->id])"></x-commentForm>

            <hr>

            <x-commentList :comments="$post->comments"></x-commentList>

        </div>

        <div class="col-4">
            @include('posts._activity')
        </div>

    </div>
@endsection
