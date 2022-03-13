@extends('layouts.app')

@section('content')
    <form action="{{ route('login') }}" method="post">
        @csrf

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
            <div class="form-check">
                <input type="checkbox" name="remember" value="{{ old('remember') ? 'checked' : '' }}" class="form-check-input">
                <label for="remember" class="form-check-label">Remember Me?</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Login</button>

    </form>
@endsection
