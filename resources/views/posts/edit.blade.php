@extends('layouts.app')

@section('title', 'Edit the Post')

@section('content')

    <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="post">
        @csrf
        @method('PUT')
        @include('posts.partials.form')
        <div>
            <button type="submit" value="Update">Update</button>
        </div>
    </form>

@endsection