@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="jumbotron text-center">
        <h1>Welcome to MEMGMENG BLOG</h1>
        <p>Please log in to view and create articles.</p>
        <a class="btn btn-primary btn-lg mt-3" href="{{ route('login') }}" role="button">login</a>
        <a class="btn btn-success btn-lg mt-3" href="{{ route('register') }}" role="button">register</a>
    </div>
</div>
@endsection
