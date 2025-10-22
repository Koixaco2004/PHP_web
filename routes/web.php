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
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProfileController;

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Search Routes
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/suggest', [SearchController::class, 'suggest'])->name('search.suggest');
Route::get('/search/popular', [SearchController::class, 'popular'])->name('search.popular');

// Routes cho người dùng đăng bài
Route::middleware(['auth'])->group(function () {
    // Route tạo bài viết mới (dành cho user thường)
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Routes quản lý bài viết (chỉ admin)
    Route::middleware(['admin'])->group(function () {
        Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    });

    // Post Images Routes
    Route::prefix('posts/{post}/images')->name('posts.images.')->group(function () {
        Route::get('/', [PostImageController::class, 'index'])->name('index');
        Route::post('/', [PostImageController::class, 'store'])->name('store');
        Route::put('/{image}', [PostImageController::class, 'update'])->name('update');
        Route::delete('/{image}', [PostImageController::class, 'destroy'])->name('destroy');
        Route::patch('/{image}/featured', [PostImageController::class, 'setFeatured'])->name('featured');
    });

    // Temporary image upload API
    Route::post('/api/upload-temp-image', [\App\Http\Controllers\Api\TempImageController::class, 'upload'])->name('api.temp-image.upload');

    // Bình luận
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Phê duyệt bình luận (chỉ admin)
    Route::middleware(['admin'])->group(function () {
        Route::patch('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    });
});

// Routes cho người dùng đã đăng nhập nhưng chưa cần verify email (xem, đọc)
Route::middleware(['auth'])->group(function () {
    // Các route không cần verify email có thể thêm ở đây nếu cần
});

// Route xem bài viết (phải đặt sau các route khác để tránh conflict)
Route::get('/posts/{slug}', [HomeController::class, 'show'])->name('posts.show');

// Routes cho admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// Route xem chuyên mục (phải đặt sau các route khác để tránh conflict)
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Google OAuth Routes
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

// Đã bỏ xác thực email, không cần route xác thực

// Newsletter Routes
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::get('/profile/posts', [ProfileController::class, 'posts'])->name('profile.posts');
    Route::get('/profile/activities', [ProfileController::class, 'activities'])->name('profile.activities');
});

// Public Profile Routes
Route::get('/users/{user}', [ProfileController::class, 'showPublic'])->name('users.show');

// Authentication routes (nếu chưa có)
require __DIR__ . '/auth.php';
