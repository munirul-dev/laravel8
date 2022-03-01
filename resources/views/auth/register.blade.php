@extends('layouts.app')

@section('content')
    <form action="{{ route('register') }}" method="post">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" id="name" required class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
            @if($errors->has('name'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" value="{{ old('email') }}" id="email" required class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
            @if($errors->has('email'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
            @if($errors->has('password'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="password_confirmation">Retype Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required class="form-control">
        </div>

        <button type="submit" class="btn btn-primary btn-block">Register</button>

    </form>
@endsection
