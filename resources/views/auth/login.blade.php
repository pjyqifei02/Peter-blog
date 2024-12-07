@extends('layouts.guest')

@section('title', 'login')

@section('content')
<div class="container">
    <h1 class="text-center my-4">login</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">remember me</label>
        </div>
        <button type="submit" class="btn btn-primary w-100">login</button>
    </form>
    <div class="text-center mt-3">
        <a href="{{ route('password.request') }}">forget password?</a>
    </div>
</div>
@endsection
