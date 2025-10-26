<div class="comment-item animate-slide-up" data-comment-id="{{ $comment->id }}" x-data="{ showToxic: false }">
    <div class="flex space-x-4">
        <div class="flex-shrink-0">
            <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                <span class="text-white font-semibold text-lg">{{ substr($comment->user->name, 0, 1) }}</span>
            </div>
        </div>
        <div class="flex-1">
            <div class="bg-secondary-50 dark:bg-gray-700 rounded-xl p-4">
                <div class="flex items-center justify-between mb-2">
                    <h5 class="font-semibold text-secondary-900 dark:text-primary-400-dark">{{ $comment->user->name }}</h5>
                    <time class="text-sm text-secondary-500 dark:text-gray-400">{{ $comment->created_at->format('d/m/Y H:i') }}</time>
                </div>
                
                @if($comment->is_toxic)
                    <!-- Toxic comment with blur effect -->
                    <div class="relative mb-3">
                        <p class="text-secondary-700 dark:text-gray-300 transition-all duration-300" :class="!showToxic ? 'blur-sm select-none' : ''">
                            {{ $comment->content }}
                        </p>
                    </div>
                    <button 
                        @click="showToxic = !showToxic" 
                        class="text-sm text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300 mb-3"
                    >
                        <span x-show="!showToxic">Hiển thị nội dung</span>
                        <span x-show="showToxic">Ẩn nội dung</span>
                    </button>
                @else
                    <!-- Normal comment -->
                    <p class="text-secondary-700 dark:text-gray-300 mb-3">{{ $comment->content }}</p>
                @endif
                
                @auth
                    <div class="flex items-center space-x-4 text-sm">
                        <button onclick="showReplyForm({{ $comment->id }})" class="text-primary-600 dark:text-primary-400-dark hover:text-primary-700 dark:hover:text-primary-300-dark font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                            </svg>
                            Trả lời
                        </button>
                        @can('delete', $comment)
                            <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Xóa
                                </button>
                            </form>
                        @endcan
                    </div>
                @endauth
            </div>

            <!-- Reply Form -->
            @auth
                <div id="reply-form-{{ $comment->id }}" class="hidden mt-4 ml-4">
                    <form method="POST" action="{{ route('comments.store', $post) }}" class="reply-form space-y-3" data-parent-id="{{ $comment->id }}">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-gradient-to-br from-primary-400 to-primary-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <textarea name="content" rows="2" class="w-full px-3 py-2 text-sm border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark bg-white dark:bg-gray-700 dark:text-primary-400-dark dark:placeholder-gray-400" placeholder="Viết câu trả lời của bạn..." required></textarea>
                                <div class="mt-2 flex items-center space-x-2">
                                    <button type="submit" class="px-3 py-1.5 text-sm bg-primary-600 dark:bg-primary-100-dark text-white dark:text-primary-900-dark rounded-lg hover:bg-primary-700 dark:hover:bg-primary-200-dark transition-colors duration-200">
                                        Gửi
                                    </button>
                                    <button type="button" onclick="hideReplyForm({{ $comment->id }})" class="px-3 py-1.5 text-sm bg-secondary-200 dark:bg-gray-600 text-secondary-700 dark:text-gray-300 rounded-lg hover:bg-secondary-300 dark:hover:bg-gray-500 transition-colors duration-200">
                                        Hủy
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endauth

            <!-- Replies (nested comments) -->
            @if($comment->children->count() > 0)
                <div class="mt-4 ml-8 space-y-4 border-l-2 border-primary-200 dark:border-gray-600 pl-4" id="replies-{{ $comment->id }}">
                    @foreach($comment->children as $reply)
                        @include('partials.reply', ['reply' => $reply, 'post' => $post])
                    @endforeach
                </div>
            @else
                <div class="mt-4 ml-8 space-y-4 border-l-2 border-primary-200 dark:border-gray-600 pl-4 hidden" id="replies-{{ $comment->id }}">
                    <!-- Replies will be added here -->
                </div>
            @endif
        </div>
    </div>
</div>
