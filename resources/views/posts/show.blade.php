@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center">{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>

    @if(Auth::check() && Auth::id() === $post->user_id)
        <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
    @endif

    <hr>


    <h3>Comments</h3>
    <ul>
        @foreach($post->comments as $comment)
            <li>{{ $comment->content }} - <small>{{ $comment->user->name }}</small></li>
        @endforeach
    </ul>

    @auth
        <form action="{{ route('posts.comments.store', $post) }}" method="POST" class="mt-3">
            @csrf
            <div class="mb-3">
                <textarea name="content" class="form-control" placeholder="Leave a comment..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Comment</button>
        </form>
    @endauth
</div>
@endsection
