@extends('layouts.app')

@section('title', 'Chính sách bảo mật')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Chính sách bảo mật</h1>
    <div class="prose dark:prose-invert max-w-none">
        <p class="text-gray-600 dark:text-gray-300 mb-4">
            Chúng tôi cam kết bảo vệ thông tin cá nhân của bạn. Chính sách bảo mật này giải thích cách chúng tôi thu thập, sử dụng và bảo vệ thông tin của bạn khi sử dụng SmurfExpress.
        </p>
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">Thông tin chúng tôi thu thập</h2>
        <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4">
            <li>Thông tin đăng ký: Tên, email, mật khẩu</li>
            <li>Thông tin hồ sơ: Ảnh đại diện, thông tin cá nhân</li>
            <li>Dữ liệu sử dụng: Lịch sử đọc bài, bình luận</li>
        </ul>
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">Cách chúng tôi sử dụng thông tin</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-4">
            Thông tin được sử dụng để cung cấp dịch vụ, cải thiện trải nghiệm người dùng và liên lạc với bạn.
        </p>
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">Bảo mật thông tin</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-4">
            Chúng tôi sử dụng các biện pháp bảo mật tiên tiến để bảo vệ thông tin của bạn khỏi truy cập trái phép.
        </p>
        <p class="text-gray-600 dark:text-gray-300">
            Nếu bạn có câu hỏi về chính sách bảo mật, vui lòng liên hệ với chúng tôi qua email: contact@smurfexpress.vn
        </p>
    </div>
</div>
@endsection