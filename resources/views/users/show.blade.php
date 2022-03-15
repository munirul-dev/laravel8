@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-4">
            <img src="{{ $user->image ? $user->image->url() : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png' }}" alt="Avatar" class="img-thumbnail avatar">
        </div>
        <div class="col-8">
            <h3>{{ $user->name }}</h3>

            <x-commentForm :route="route('users.comments.store', ['user' => $user->id])"></x-commentForm>

            <p>Currently viewed by {{ $counter }} other users</p>

            <hr>

            <x-commentList :comments="$user->commentsOn"></x-commentList>
        </div>
    </div>
@endsection
