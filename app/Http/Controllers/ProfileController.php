<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Hiển thị profile của người dùng.
     */
    public function show()
    {
        /** @var User $user */
        $user = Auth::user();
        // User có thể xem cả draft và published posts của chính mình
        $posts = Post::where('user_id', $user->id)->with('category')->latest()->paginate(5);
        $totalComments = Comment::where('user_id', $user->id)->count();

        return view('profile.show', compact('user', 'posts', 'totalComments'));
    }

    /**
     * Hiển thị profile công khai của người dùng khác.
     */
    public function showPublic(User $user)
    {
        // Tăng số lượt xem profile
        $user->increment('profile_views');

        // Chỉ hiển thị bài viết đã published và approved cho public profile
        $posts = Post::where('user_id', $user->id)
            ->where('status', 'published')
            ->where('approval_status', 'approved')
            ->with('category')
            ->latest()
            ->paginate(5);

        // Tính số bài viết published và approved
        $publishedPostsCount = Post::where('user_id', $user->id)
            ->where('status', 'published')
            ->where('approval_status', 'approved')
            ->count();

        // Tính số bình luận từ các bài viết published và approved
        $publishedPostsIds = Post::where('user_id', $user->id)
            ->where('status', 'published')
            ->where('approval_status', 'approved')
            ->pluck('id');
        $totalComments = Comment::whereIn('post_id', $publishedPostsIds)->count();

        return view('profile.public', compact('user', 'posts', 'publishedPostsCount', 'totalComments'));
    }

    /**
     * Hiển thị form chỉnh sửa profile của người dùng.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Cập nhật thông tin profile của người dùng.
     */
    public function update(UpdateProfileRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $validated = $request->validated();
        unset($validated['email']);

        User::where('id', $user->id)->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    /**
     * Tải lên hoặc cập nhật avatar của người dùng.
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = Auth::user();

        // Xóa avatar cũ nếu tồn tại
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Tải lên avatar mới
        $avatarPath = $request->file('avatar')->store('avatars', 'public');

        User::where('id', $user->id)->update(['avatar' => $avatarPath]);

        return redirect()->route('profile.show')->with('success', 'Avatar updated successfully!');
    }

    /**
     * Hiển thị form đổi mật khẩu.
     */
    public function showChangePasswordForm()
    {
        $user = Auth::user();
        return view('profile.change-password', compact('user'));
    }

    /**
     * Cập nhật mật khẩu người dùng.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'current_password.current_password' => 'Mật khẩu hiện tại không đúng.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        ]);

        $user = Auth::user();
        User::where('id', $user->id)->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.edit')->with('success', 'Đổi mật khẩu thành công!');
    }

    /**
     * Hiển thị bài viết của người dùng.
     */
    public function posts(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $query = Post::where('user_id', $user->id)->with('category', 'images');

        // Lọc theo trạng thái nếu được chỉ định
        if ($request->has('status') && in_array($request->status, ['published', 'draft'])) {
            $query->where('status', $request->status);
        }

        // Lọc theo trạng thái phê duyệt
        if ($request->has('approval') && in_array($request->approval, ['pending', 'approved', 'rejected'])) {
            $query->where('approval_status', $request->approval);
        }

        // Lọc theo chuyên mục
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Tìm kiếm theo tiêu đề
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sắp xếp
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

        // Lấy chế độ xem (bình thường hoặc lưới)
        $viewMode = $request->get('view', 'grid');

        return view('profile.posts', compact('user', 'posts', 'categories', 'viewMode'));
    }

    /**
     * Hiển thị hoạt động của người dùng.
     */
    public function activities()
    {
        /** @var User $user */
        $user = Auth::user();
        $comments = Comment::where('user_id', $user->id)->with('post')->latest()->paginate(10);

        return view('profile.activities', compact('user', 'comments'));
    }
}
