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
        $posts = Post::where('user_id', $user->id)->with('category')->latest()->paginate(5);
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
    public function posts()
    {
        /** @var User $user */
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->with('category')->latest()->paginate(10);
        
        return view('profile.posts', compact('user', 'posts'));
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
