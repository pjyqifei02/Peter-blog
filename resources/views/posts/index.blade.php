@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center">Post List</h1>

    {{-- Display each post --}}
    @foreach($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                {{-- If the post has an image, display it --}}
                @if ($post->image_path)
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Image" class="img-fluid mb-3">
                @endif

                {{-- Display the post title and content --}}
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ Str::limit($post->content, 150, '...') }}</p>

                {{-- Read More button --}}
                <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Read More</a>

                {{-- If the user is the author, show edit and delete buttons --}}
                @auth
                    @if (Auth::id() === $post->user_id)
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    @endif
                @endauth
            </div>

            {{-- Comments section --}}
            <div class="card-footer">
                {{-- Display existing comments --}}
                @if($post->comments->count())
                    <h6>Comments:</h6>
                    <ul class="list-unstyled">
                        @foreach($post->comments as $comment)
                            <li>
                                <strong>{{ $comment->user->name }}:</strong> 
                                {{ $comment->content }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No comments yet.</p>
                @endif

                {{-- Logged-in users can add comments --}}
                @auth
                    <form action="{{ route('posts.comments.store', $post) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="mb-3">
                            <textarea name="content" class="form-control" placeholder="Add a comment" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-secondary">Submit Comment</button>
                    </form>
                @else
                    <p class="text-muted mt-3">Please <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a> to add a comment.</p>
                @endauth
            </div>
        </div>
    @endforeach

    {{-- Logged-in users can create new posts --}}
    @auth
        <a href="{{ route('posts.create') }}" class="btn btn-success mt-4">Create New Post</a>
    @else
        <div class="alert alert-warning mt-4">
            Please <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a> to create a new post.
        </div>
    @endauth

    {{-- File upload functionality --}}
    @auth
        <div class="mt-4">
            <h3>Upload File</h3>
            <form action="{{ route('uploads.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Select File</label>
                    <input type="file" name="file" id="file" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>

            {{-- Display user's uploaded files --}}
            @if($uploads->count())
                <h5 class="mt-4">Uploaded Files:</h5>
                <ul class="list-unstyled">
                    @foreach($uploads as $upload)
                        <li>
                            <a href="{{ asset('storage/' . $upload->file_path) }}" target="_blank">{{ $upload->file_name }}</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted mt-3">No files uploaded yet.</p>
            @endif
        </div>
    @endauth
</div>
@endsection
