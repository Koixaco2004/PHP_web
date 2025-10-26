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
            
            @can('delete', $reply)
                <form method="POST" action="{{ route('comments.destroy', $reply) }}" class="inline mt-2" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-medium flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Xóa
                    </button>
                </form>
            @endcan
        </div>
    </div>
</div>
