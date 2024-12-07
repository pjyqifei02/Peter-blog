<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Upload;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        // Retrieve all posts
        $posts = Post::with('comments')->latest()->get();

        // If the user is logged in, retrieve their uploaded files
        $uploads = Auth::check() ? Upload::where('user_id', Auth::id())->get() : collect();

        // Pass the data to the view
        return view('posts.index', compact('posts', 'uploads'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('home')->with('success', 'Post successfully created!');
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to edit this post');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to update this post');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update($request->only(['title', 'content']));

        return redirect()->route('posts.show', $post)->with('success', 'Post successfully updated!');
    }

    public function destroy(Post $post)
    {
        // Check if the user is an admin or the post author
        if ($post->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'You do not have permission to delete this post');
        }

        $post->delete();

        return redirect()->route('home')->with('success', 'Post successfully deleted!');
    }
}
