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

                <div class="row mb-4">
                    <div class="card w-100">
                        <div class="card-body">
                            <h5 class="card-title">Most Commented</h5>
                            <h6 class="card-subtitle text-muted">What people are currently talking about</h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @forelse ($mostCommented as $post)
                                <li class="list-group-item">
                                    <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                                    <p class="m-0 text-muted">{{ $post->comments_count }} comments</p>
                                </li>
                            @empty
                                <li class="list-group-item">No posts found.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="card w-100">
                        <div class="card-body">
                            <h5 class="card-title">Most Active</h5>
                            <h6 class="card-subtitle text-muted">Users with the most posts written</h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @forelse ($mostActive as $user)
                                <li class="list-group-item">{{ $user->name }}</li>
                            @empty
                                <li class="list-group-item">No users found.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="card w-100">
                        <div class="card-body">
                            <h5 class="card-title">Most Active Last Month</h5>
                            <h6 class="card-subtitle text-muted">Users with the most posts written last month</h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @forelse ($mostActiveLastMonths as $user)
                                <li class="list-group-item">{{ $user->name }}</li>
                            @empty
                                <li class="list-group-item">No users found.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
