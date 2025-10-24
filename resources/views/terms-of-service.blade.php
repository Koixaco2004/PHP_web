@extends('layouts.app')

@section('title', 'Điều khoản sử dụng')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Điều khoản sử dụng</h1>
    <div class="prose dark:prose-invert max-w-none">
        <p class="text-gray-600 dark:text-gray-300 mb-4">
            Chào mừng bạn đến với SmurfExpress. Bằng việc sử dụng trang web này, bạn đồng ý tuân thủ các điều khoản và điều kiện sau đây.
        </p>
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">Quyền và trách nhiệm của người dùng</h2>
        <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4">
            <li>Bạn phải cung cấp thông tin chính xác khi đăng ký.</li>
            <li>Không được đăng nội dung vi phạm pháp luật, xúc phạm hoặc spam.</li>
            <li>Tôn trọng quyền sở hữu trí tuệ của người khác.</li>
        </ul>
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">Quyền của SmurfExpress</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-4">
            Chúng tôi có quyền xóa nội dung vi phạm, tạm ngừng tài khoản và thay đổi dịch vụ mà không cần thông báo trước.
        </p>
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">Miễn trừ trách nhiệm</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-4">
            SmurfExpress không chịu trách nhiệm về nội dung do người dùng đăng tải hoặc các liên kết bên ngoài.
        </p>
        <p class="text-gray-600 dark:text-gray-300">
            Các điều khoản này có thể được cập nhật bất kỳ lúc nào. Vui lòng kiểm tra thường xuyên.
        </p>
    </div>
</div>
@endsection