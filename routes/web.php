<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostImageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/suggest', [SearchController::class, 'suggest'])->name('search.suggest');
Route::get('/search/popular', [SearchController::class, 'popular'])->name('search.popular');

Route::middleware(['auth'])->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/posts', [PostController::class, 'index'])->name('posts.index');
        Route::get('/admin/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/admin/posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/admin/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    });

    Route::prefix('posts/{post}/images')->name('posts.images.')->group(function () {
        Route::get('/', [PostImageController::class, 'index'])->name('index');
        Route::post('/', [PostImageController::class, 'store'])->name('store');
        Route::put('/{image}', [PostImageController::class, 'update'])->name('update');
        Route::delete('/{image}', [PostImageController::class, 'destroy'])->name('destroy');
        Route::patch('/{image}/featured', [PostImageController::class, 'setFeatured'])->name('featured');
    });

    Route::post('/api/upload-temp-image', [\App\Http\Controllers\Api\TempImageController::class, 'upload'])->name('api.temp-image.upload');

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
});

Route::get('/posts/{slug}', [HomeController::class, 'show'])->name('posts.show');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    Route::get('/admin/comments', [AdminController::class, 'comments'])->name('admin.comments.index');
    Route::delete('/admin/comments/{comment}', [AdminController::class, 'destroyComment'])->name('admin.comments.destroy');

    Route::get('/admin/posts/pending', [AdminController::class, 'pendingPosts'])->name('admin.posts.pending');
    Route::post('/admin/posts/{post}/approve', [AdminController::class, 'approvePost'])->name('admin.posts.approve');
    Route::post('/admin/posts/{post}/reject', [AdminController::class, 'rejectPost'])->name('admin.posts.reject');

    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar');
    Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');
    Route::put('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::get('/profile/posts', [ProfileController::class, 'posts'])->name('profile.posts');
    Route::get('/profile/activities', [ProfileController::class, 'activities'])->name('profile.activities');
});

Route::get('/users/{user}', [ProfileController::class, 'showPublic'])->name('users.show');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/terms-of-service', function () {
    return view('terms-of-service');
})->name('terms-of-service');

Route::get('/support', function () {
    return view('support');
})->name('support');

require __DIR__ . '/auth.php';
