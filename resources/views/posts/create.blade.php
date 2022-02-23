@extends('layouts.app')

@section('title', 'Create the Post')

@section('content')

    <form action="{{ route('posts.store') }}" method="post">
        @csrf
        @include('posts.partials.form')
        <div>
            <button type="submit" value="Create">Submit</button>
        </div>
    </form>

@endsection
