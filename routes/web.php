<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\CommentController;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');


Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/home', [PostController::class, 'index'])->middleware(['auth'])->name('home');


Route::resource('posts', PostController::class)->middleware(['auth']);


Route::middleware(['auth'])->group(function () {
    Route::get('/uploads/create', [UploadController::class, 'create'])->name('uploads.create');
    Route::post('/uploads', [UploadController::class, 'store'])->name('uploads.store');
    Route::delete('/uploads/{id}', [UploadController::class, 'destroy'])->name('uploads.destroy');
});



Route::post('posts/{post}/comments', [CommentController::class, 'store'])->middleware('auth')->name('posts.comments.store');


require __DIR__.'/auth.php';
