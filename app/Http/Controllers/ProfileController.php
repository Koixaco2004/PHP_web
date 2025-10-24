<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        /** @var User $user */
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->with('category')->latest()->take(3)->get();
        $totalComments = Comment::where('user_id', $user->id)->count();

        return view('profile.show', compact('user', 'posts', 'totalComments'));
    }

    /**
     * Display another user's public profile.
     */
    public function showPublic(User $user)
    {
        // Tăng số lượt xem profile
        $user->increment('profile_views');

        // Nếu profile riêng tư và không phải chủ sở hữu
        if ($user->is_private && Auth::id() !== $user->id) {
            abort(403, 'This profile is private.');
        }

        $posts = Post::where('user_id', $user->id)->with('category')->latest()->paginate(5);
        $totalComments = Comment::where('user_id', $user->id)->count();

        return view('profile.public', compact('user', 'posts', 'totalComments'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateProfileRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $validated = $request->validated();

        // Loại bỏ email khỏi danh sách cập nhật để không cho phép thay đổi email
        unset($validated['email']);

        User::where('id', $user->id)->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    /**
     * Upload or update user avatar.
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = Auth::user();

        // Xóa avatar cũ nếu có
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Upload avatar mới
        $avatarPath = $request->file('avatar')->store('avatars', 'public');

        User::where('id', $user->id)->update(['avatar' => $avatarPath]);

        return redirect()->route('profile.show')->with('success', 'Avatar updated successfully!');
    }

    /**
     * Show password change form.
     */
    public function settings()
    {
        $user = Auth::user();
        return view('profile.settings', compact('user'));
    }

    /**
     * Change user password.
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $userId = Auth::id();
        User::where('id', $userId)->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.settings')->with('success', 'Password changed successfully!');
    }

    /**
     * Show user's posts.
     */
    public function posts(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $query = Post::where('user_id', $user->id)->with('category', 'images');

        // Filter by status
        if ($request->has('status') && in_array($request->status, ['published', 'draft'])) {
            $query->where('status', $request->status);
        }

        // Filter by approval status
        if ($request->has('approval') && in_array($request->approval, ['pending', 'approved', 'rejected'])) {
            $query->where('approval_status', $request->approval);
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Search by title
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'most_viewed':
                $query->orderBy('view_count', 'desc');
                break;
            case 'most_commented':
                $query->orderBy('comment_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $posts = $query->paginate(12);
        $categories = \App\Models\Category::active()->get();

        // Get view mode (normal or grid)
        $viewMode = $request->get('view', 'grid');

        return view('profile.posts', compact('user', 'posts', 'categories', 'viewMode'));
    }

    /**
     * Show user's activities.
     */
    public function activities()
    {
        /** @var User $user */
        $user = Auth::user();
        $comments = Comment::where('user_id', $user->id)->with('post')->latest()->paginate(10);

        return view('profile.activities', compact('user', 'comments'));
    }
}
