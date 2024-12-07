<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Upload;

class UploadController extends Controller
{
    public function create()
    {
        $uploads = Upload::where('user_id', Auth::id())->get();
        return view('uploads.create', compact('uploads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        // Store the file in the 'uploads' directory
        $path = $request->file('file')->store('uploads', 'public');

        // Create a record of the uploaded file
        Upload::create([
            'original_name' => $request->file('file')->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $request->file('file')->getClientMimeType(),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('uploads.create')->with('success', 'File uploaded successfully!');
    }

    public function destroy($id)
    {
        $upload = Upload::findOrFail($id);

        if ($upload->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'You do not have permission to delete this file');
        }

        // Delete the stored file
        Storage::disk('public')->delete($upload->path);
        $upload->delete();

        return redirect()->route('uploads.create')->with('success', 'File deleted successfully!');
    }
}
