@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')

    @forelse ($posts as $key => $post)
        @include('posts.partials.post')
    @empty
        <h1>No posts found.</h1>
        <p>This is the content of the main page.</p>
    @endforelse

@endsection
