<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

/**
 * Chính sách phân quyền cho Comment.
 * Quản lý quyền truy cập, xem, tạo, chỉnh sửa và xóa bình luận.
 */
class CommentPolicy
{
    /**
     * Kiểm tra người dùng có quyền xem danh sách bình luận.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Kiểm tra người dùng có quyền xem chi tiết bình luận.
     */
    public function view(User $user, Comment $comment): bool
    {
        return true;
    }

    /**
     * Kiểm tra người dùng có quyền tạo bình luận mới.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Kiểm tra người dùng có quyền chỉnh sửa bình luận.
     * Chỉ chủ sở hữu bình luận mới được phép chỉnh sửa, không kể quản trị viên.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Kiểm tra người dùng có quyền xóa bình luận.
     * Chủ sở hữu hoặc quản trị viên có thể xóa bình luận.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id || $user->isAdmin();
    }

    /**
     * Kiểm tra người dùng có quyền khôi phục bình luận đã xóa.
     * Chỉ quản trị viên có thể khôi phục.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return $user->isAdmin();
    }

    /**
     * Kiểm tra người dùng có quyền xóa vĩnh viễn bình luận.
     * Chỉ quản trị viên có thể xóa vĩnh viễn.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return $user->isAdmin();
    }
}
