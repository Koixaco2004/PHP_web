<div class="flex space-x-3" data-reply-id="{{ $reply->id }}" x-data="{ showToxic: false }">
    <div class="flex-shrink-0">
        <div class="w-10 h-10 bg-gradient-to-br from-primary-400 to-primary-500 rounded-full flex items-center justify-center">
            <span class="text-white font-semibold">{{ substr($reply->user->name, 0, 1) }}</span>
        </div>
    </div>
    <div class="flex-1">
        <div class="bg-primary-50 dark:bg-gray-700/50 rounded-lg p-3 border border-primary-100 dark:border-gray-600">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center space-x-2">
                    <h5 class="font-semibold text-secondary-900 dark:text-primary-400-dark text-sm">{{ $reply->user->name }}</h5>
                    <span class="text-xs text-primary-600 dark:text-primary-400-dark bg-primary-100 dark:bg-primary-900-dark px-2 py-0.5 rounded-full">Trả lời</span>
                </div>
                <time class="text-xs text-secondary-500 dark:text-gray-400">{{ $reply->created_at->format('d/m/Y H:i') }}</time>
            </div>
            
            <!-- Reply Content Display -->
            <div class="reply-content-display-{{ $reply->id }}">
                @if($reply->is_toxic)
                    <!-- Toxic reply with blur effect -->
                    <div class="relative mb-2">
                        <p class="text-secondary-700 dark:text-gray-300 text-sm transition-all duration-300" :class="!showToxic ? 'blur-sm select-none' : ''">
                            {{ $reply->content }}
                        </p>
                    </div>
                    <button 
                        @click="showToxic = !showToxic" 
                        class="text-xs text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300 mb-2"
                    >
                        <span x-show="!showToxic">Hiển thị</span>
                        <span x-show="showToxic">Ẩn</span>
                    </button>
                @else
                    <!-- Normal reply -->
                    <p class="text-secondary-700 dark:text-gray-300 text-sm">{{ $reply->content }}</p>
                @endif
            </div>
            
            <!-- Reply Edit Form (Initially Hidden) -->
            <div class="reply-edit-form-{{ $reply->id }} hidden mb-2">
                <textarea class="w-full px-3 py-2 text-sm border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark bg-white dark:bg-gray-700 dark:text-primary-400-dark dark:placeholder-gray-400" rows="2">{{ $reply->content }}</textarea>
                <div class="mt-2 flex items-center space-x-2">
                    <button onclick="saveEditReply({{ $reply->id }})" class="px-3 py-1.5 text-sm bg-primary-600 dark:bg-primary-100-dark text-white dark:text-primary-900-dark rounded-lg hover:bg-primary-700 dark:hover:bg-primary-200-dark transition-colors duration-200">
                        Lưu
                    </button>
                    <button onclick="cancelEditReply({{ $reply->id }})" class="px-3 py-1.5 text-sm bg-secondary-200 dark:bg-gray-600 text-secondary-700 dark:text-gray-300 rounded-lg hover:bg-secondary-300 dark:hover:bg-gray-500 transition-colors duration-200">
                        Hủy
                    </button>
                </div>
            </div>
            
            @can('update', $reply)
                <button onclick="showEditReply({{ $reply->id }})" class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium flex items-center mt-2">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Sửa
                </button>
            @endcan
            
            @can('delete', $reply)
                <button onclick="deleteComment({{ $reply->id }}, true)" class="text-xs text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-medium flex items-center mt-2">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Xóa
                </button>
            @endcan
        </div>
    </div>
</div>
