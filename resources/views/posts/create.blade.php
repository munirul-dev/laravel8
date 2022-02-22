@extends('layouts.app')

@section('title', 'Create the Post')

@section('content')

    <form action="{{ route('posts.store') }}" method="post">
        @csrf
        <div>
            <input type="text" name="title" value={{ old('title') }}>
        </div>

        <div>
            <textarea name="content">{{ old('content') }}</textarea>
        </div>

        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <button type="submit" value="Create">Submit</button>
        </div>
    </form>

@endsection
