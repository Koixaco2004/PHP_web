@extends('layouts.app')

@section('title', 'Bài viết chờ phê duyệt')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-primary-600 to-primary-800 dark:from-primary-800 dark:to-primary-900 rounded-xl shadow-lg p-8 mb-8 animate-slide-up">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <div class="w-16 h-16 bg-white bg-opacity-20 dark:bg-white dark:bg-opacity-30 rounded-xl flex items-center justify-center mr-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-4xl font-heading font-bold text-white">Bài viết chờ phê duyệt</h1>
                <p class="text-primary-100 dark:text-primary-200 mt-2">Quản lý và phê duyệt các bài viết từ tác giả</p>
            </div>
        </div>
        <div class="hidden lg:flex items-center">
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-lg transition-all duration-200">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Quay lại Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-secondary-600 dark:text-gray-300">Chờ phê duyệt</p>
                <p class="text-2xl font-bold text-secondary-900 dark:text-white">{{ $pendingPosts->total() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Posts List -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700">
    <div class="p-6">
        <h2 class="text-xl font-semibold text-secondary-900 dark:text-white mb-4">Danh sách bài viết</h2>

        @if($pendingPosts->isEmpty())
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-secondary-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-secondary-600 dark:text-gray-400 text-lg">Không có bài viết nào chờ phê duyệt</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-secondary-200 dark:divide-gray-700">
                    <thead class="bg-secondary-50 dark:bg-gray-900">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-400 uppercase tracking-wider">
                                Bài viết
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-400 uppercase tracking-wider">
                                Tác giả
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-400 uppercase tracking-wider">
                                Chuyên mục
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-400 uppercase tracking-wider">
                                Ngày tạo
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-secondary-500 dark:text-gray-400 uppercase tracking-wider">
                                Hành động
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-secondary-200 dark:divide-gray-700">
                        @foreach($pendingPosts as $post)
                            <tr class="hover:bg-secondary-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-secondary-900 dark:text-white">
                                                {{ Str::limit($post->title, 50) }}
                                            </div>
                                            <div class="text-sm text-secondary-500 dark:text-gray-400">
                                                {{ Str::limit(strip_tags($post->excerpt), 80) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($post->user->avatar)
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-primary-500 flex items-center justify-center">
                                                    <span class="text-white font-medium text-sm">{{ strtoupper(substr($post->user->name, 0, 1)) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-secondary-900 dark:text-white">
                                                {{ $post->user->name }}
                                            </div>
                                            <div class="text-sm text-secondary-500 dark:text-gray-400">
                                                {{ $post->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200">
                                        {{ $post->category->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-500 dark:text-gray-400">
                                    {{ $post->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- View Button -->
                                        <a href="{{ route('posts.show', $post->slug) }}" 
                                           class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300"
                                           title="Xem bài viết">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        
                                        <!-- Approve Button -->
                                        <form action="{{ route('admin.posts.approve', $post) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" 
                                                    class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
                                                    title="Phê duyệt"
                                                    onclick="return confirm('Bạn có chắc chắn muốn phê duyệt bài viết này?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </button>
                                        </form>
                                        
                                        <!-- Reject Button -->
                                        <button type="button"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                title="Từ chối"
                                                onclick="openRejectModal({{ $post->id }}, '{{ $post->title }}')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $pendingPosts->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 dark:bg-gray-900 dark:bg-opacity-75 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-xl bg-white dark:bg-gray-800">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Từ chối bài viết</h3>
                <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <form id="rejectForm" method="POST">
                @csrf
                <input type="hidden" id="rejectPostId" name="post_id">
                
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    Bạn đang từ chối bài viết: <span id="rejectPostTitle" class="font-semibold text-gray-900 dark:text-white"></span>
                </p>

                <!-- Reason Dropdown -->
                <div class="mb-4">
                    <label for="reasonSelect" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Lý do từ chối <span class="text-red-500">*</span>
                    </label>
                    <select id="reasonSelect" 
                            name="rejection_reason_type"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400-dark focus:border-transparent"
                            onchange="toggleCustomReason()"
                            required>
                        <option value="">-- Chọn lý do --</option>
                        <option value="Nội dung vi phạm quy định cộng đồng">Nội dung vi phạm quy định cộng đồng</option>
                        <option value="Tiêu đề không phù hợp hoặc spam">Tiêu đề không phù hợp hoặc spam</option>
                        <option value="Nội dung thiếu chính xác hoặc sai sự thật">Nội dung thiếu chính xác hoặc sai sự thật</option>
                        <option value="Bài viết trùng lặp">Bài viết trùng lặp</option>
                        <option value="Chất lượng nội dung không đạt yêu cầu">Chất lượng nội dung không đạt yêu cầu</option>
                        <option value="Hình ảnh không phù hợp">Hình ảnh không phù hợp</option>
                        <option value="other">Khác (nhập lý do)</option>
                    </select>
                </div>

                <!-- Custom Reason Input -->
                <div id="customReasonDiv" class="mb-4 hidden">
                    <label for="customReason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nhập lý do cụ thể <span class="text-red-500">*</span>
                    </label>
                    <textarea id="customReason"
                              name="custom_rejection_reason"
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400-dark focus:border-transparent"
                              placeholder="Nhập lý do từ chối chi tiết..."></textarea>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button"
                            onclick="closeRejectModal()"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                        Hủy bỏ
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-150">
                        Xác nhận từ chối
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openRejectModal(postId, postTitle) {
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectPostId').value = postId;
    document.getElementById('rejectPostTitle').textContent = postTitle;
    document.getElementById('rejectForm').action = `/admin/posts/${postId}/reject`;
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('reasonSelect').value = '';
    document.getElementById('customReason').value = '';
    document.getElementById('customReasonDiv').classList.add('hidden');
}

function toggleCustomReason() {
    const select = document.getElementById('reasonSelect');
    const customDiv = document.getElementById('customReasonDiv');
    const customInput = document.getElementById('customReason');
    
    if (select.value === 'other') {
        customDiv.classList.remove('hidden');
        customInput.required = true;
    } else {
        customDiv.classList.add('hidden');
        customInput.required = false;
        customInput.value = '';
    }
}

// Close modal when clicking outside
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});
</script>
@endsection
