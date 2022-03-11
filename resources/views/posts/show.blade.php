@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="row">

        <div class="col-8">

            <h1>
                {{ $post->title }}
                <x-badge type="success" :show="now()->diffInMinutes($post->created_at) < 5">
                    New!
                </x-badge>
            </h1>

            <p>{{ $post->content }}</p>
            <x-updated :date="$post->created_at->diffForHumans()" name="{{ $post->user->name }}"></x-updated>
            <x-updated :date="$post->updated_at->diffForHumans()">Updated</x-updated>
            <x-tags :tags="$post->tags"></x-tags>


            <p>Currently read by {{ $counter }} people</p>

            <hr>

            <h4>Comments</h4>

            @forelse ($post->comments as $comment)
                <p class="mb-0">{{ $comment->content }}</p>
                <x-updated :date="$comment->created_at->diffForHumans()">Commented</x-updated>
            @empty
                <p>No comments yet.</p>
            @endforelse

        </div>

        <div class="col-4">
            @include('posts._activity')
        </div>

    </div>
@endsection
