@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center">File Upload</h1>

    {{-- File upload form --}}
    <form action="{{ route('uploads.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Select File</label>
            <input type="file" name="file" id="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    {{-- Display user uploaded files --}}
    @if($uploads->count())
        <h2 class="mt-5">Uploaded Files</h2>
        <ul class="list-group">
            @foreach($uploads as $upload)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $upload->original_name }}</strong>
                        <a href="{{ asset('storage/' . $upload->path) }}" target="_blank" class="btn btn-link">View</a>
                    </div>
                    <form action="{{ route('uploads.destroy', $upload->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p class="mt-3 text-muted">You haven't uploaded any files yet.</p>
    @endif
</div>
@endsection
