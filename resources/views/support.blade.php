@extends('layouts.app')

@section('title', 'Hỗ trợ')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Hỗ trợ</h1>
    <div class="prose dark:prose-invert max-w-none">
        <p class="text-gray-600 dark:text-gray-300 mb-4">
            Chúng tôi luôn sẵn sàng hỗ trợ bạn. Nếu bạn gặp vấn đề hoặc có câu hỏi, hãy liên hệ với chúng tôi qua các kênh sau.
        </p>
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">Liên hệ</h2>
        <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4">
            <li>Email: contact@smurfexpress.vn</li>
            <li>Điện thoại: 0123 456 789</li>
            <li>Địa chỉ: 140 Lê Trọng Tấn, Phường Tây Thạnh, TP.HCM</li>
        </ul>
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">Câu hỏi thường gặp</h2>
        <div class="space-y-4">
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Làm thế nào để đăng bài?</h3>
                <p class="text-gray-600 dark:text-gray-300">Đăng nhập vào tài khoản và chọn "Viết bài" từ menu.</p>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Tôi quên mật khẩu?</h3>
                <p class="text-gray-600 dark:text-gray-300">Sử dụng chức năng "Quên mật khẩu" trên trang đăng nhập.</p>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Báo cáo nội dung vi phạm?</h3>
                <p class="text-gray-600 dark:text-gray-300">Liên hệ với chúng tôi qua email để báo cáo.</p>
            </div>
        </div>
        <p class="text-gray-600 dark:text-gray-300 mt-6">
            Chúng tôi sẽ phản hồi trong vòng 24-48 giờ.
        </p>
    </div>
</div>
@endsection