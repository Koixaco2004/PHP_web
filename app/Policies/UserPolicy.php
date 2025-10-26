<?php

namespace App\Policies;

use App\Models\User;

/**
 * Chính sách phân quyền cho mô hình User.
 * Kiểm soát các hành động xem, tạo, cập nhật, và xóa người dùng dựa trên quyền quản trị viên.
 */
class UserPolicy
{
    /**
     * Kiểm tra xem người dùng có quyền xem danh sách tất cả người dùng hay không.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Kiểm tra xem người dùng có quyền xem chi tiết một người dùng cụ thể hay không.
     */
    public function view(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Kiểm tra xem người dùng có quyền tạo mới một người dùng hay không.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Kiểm tra xem người dùng có quyền cập nhật thông tin một người dùng hay không.
     */
    public function update(User $user, User $model): bool
    {
        // Chỉ cho phép quản trị viên cập nhật, nhưng không cho tự cập nhật chính mình
        return $user->isAdmin() && $user->id !== $model->id;
    }

    /**
     * Kiểm tra xem người dùng có quyền xóa mềm một người dùng hay không.
     */
    public function delete(User $user, User $model): bool
    {
        // Chỉ cho phép quản trị viên xóa, nhưng không cho tự xóa chính mình
        return $user->isAdmin() && $user->id !== $model->id;
    }

    /**
     * Kiểm tra xem người dùng có quyền khôi phục một người dùng bị xóa mềm hay không.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Kiểm tra xem người dùng có quyền xóa vĩnh viễn một người dùng hay không.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->isAdmin();
    }
}
