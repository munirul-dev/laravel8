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
            @include('posts._activity')
        </div>

    </div>
@endsection
