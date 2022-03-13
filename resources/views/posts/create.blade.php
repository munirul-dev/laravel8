@extends('layouts.app')

@section('title', 'Create the Post')

@section('content')

    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('posts.partials.form')
        <div>
            <button type="submit" value="Create" class="btn btn-primary btn-block">Submit</button>
        </div>
    </form>

@endsection
