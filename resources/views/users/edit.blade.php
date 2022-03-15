@extends('layouts.app')

@section('content')
    <form action="{{ route('users.update', ['user' => $user->id]) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-4">

                <img src="{{ $user->image ? $user->image->url() : '' }}" alt="Avatar" class="img-thumbnail avatar">

                <div class="card mt-4">
                    <div class="card-body">
                        <h6>Upload a different photo</h6>
                        <input type="file" name="avatar" class="form-control-file">
                    </div>
                </div>

            </div>
            <div class="col-8">

                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                </div>

                <div class="form-group">
                    <label>{{ __('Language') }}:</label>
                    <select name="locale" class="form-control">
                        @foreach (App\Models\User::LOCALES as $local => $label)
                            <option value="{{ $local }}" {{ $user->locale === $local ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Save Changes">
                </div>

            </div>
        </div>
    </form>

    <x-errors></x-errors>
@endsection
