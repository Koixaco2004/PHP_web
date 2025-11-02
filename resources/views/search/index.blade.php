@extends('layouts.app')

@section('title', 'Tìm kiếm - ' . ($query ?? ''))

@section('content')
<!-- Search Header -->
<div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-xl shadow-lg p-4 sm:p-8 mb-6 sm:mb-8">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-4 sm:mb-6">
            <h1 class="text-2xl sm:text-4xl font-heading font-bold text-white mb-2 sm:mb-4">
                Tìm kiếm nội dung
            </h1>
            <p class="text-sm sm:text-lg text-primary-100">
                Khám phá hàng ngàn bài viết chất lượng với công cụ tìm kiếm thông minh
            </p>
        </div>
        
        <!-- Search Form -->
        <form method="GET" action="{{ route('search') }}" class="relative">
            <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4">
                <div class="flex-1 relative">
                    <input type="text"
                           name="q"
                           value="{{ $query ?? request('q') }}"
                           placeholder="Nhập từ khóa tìm kiếm..."
                           class="block w-full pl-3 sm:pl-4 pr-3 sm:pr-4 py-3 sm:py-4 text-base sm:text-lg text-secondary-900 dark:text-primary-100-dark border border-secondary-300 dark:border-primary-700-dark rounded-xl bg-white dark:bg-primary-900-dark focus:ring-2 focus:ring-white dark:focus:ring-primary-700-dark focus:border-white dark:focus:border-primary-700-dark transition-colors duration-200"
                           autocomplete="off"
                           autofocus>
                </div>
                
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                    <select name="category" class="px-3 sm:px-4 py-3 sm:py-4 text-sm sm:text-base text-secondary-900 dark:text-primary-100-dark border border-secondary-300 dark:border-primary-700-dark rounded-xl bg-white dark:bg-primary-900-dark focus:ring-2 focus:ring-white dark:focus:ring-primary-700-dark focus:border-white dark:focus:border-primary-700-dark transition-colors duration-200">
                        <option value="">Tất cả chuyên mục</option>
                        @if(isset($categories))
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->posts_count ?? 0 }})
                                </option>
                            @endforeach
                        @endif
                    </select>
                    
                    <button type="submit" class="px-4 sm:px-8 py-3 sm:py-4 bg-white text-primary-600 font-semibold rounded-xl hover:bg-secondary-50 transition-colors duration-200 flex items-center justify-center text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Tìm kiếm
                    </button>
                </div>
            </div>
            
            <!-- Advanced Filters -->
            <div class="mt-3 sm:mt-4 bg-white bg-opacity-10 rounded-lg p-3 sm:p-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4">
                    <!-- Author Filter -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-white mb-1 sm:mb-2">Tác giả</label>
                        <select name="author" class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base text-secondary-900 dark:text-primary-100-dark border border-secondary-300 dark:border-primary-700-dark rounded-lg bg-white dark:bg-primary-900-dark focus:ring-2 focus:ring-white dark:focus:ring-primary-700-dark focus:border-white dark:focus:border-primary-700-dark">
                            <option value="">Tất cả tác giả</option>
                            @if(isset($authors))
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                                        {{ $author->name }} ({{ $author->posts_count ?? 0 }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <!-- Date Range -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-white mb-1 sm:mb-2">Từ ngày</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                               class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base text-secondary-900 dark:text-primary-100-dark border border-secondary-300 dark:border-primary-700-dark rounded-lg bg-white dark:bg-primary-900-dark focus:ring-2 focus:ring-white dark:focus:ring-primary-700-dark focus:border-white dark:focus:border-primary-700-dark">
                    </div>
                    
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-white mb-1 sm:mb-2">Đến ngày</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                               class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base text-secondary-900 dark:text-primary-100-dark border border-secondary-300 dark:border-primary-700-dark rounded-lg bg-white dark:bg-primary-900-dark focus:ring-2 focus:ring-white dark:focus:ring-primary-700-dark focus:border-white dark:focus:border-primary-700-dark">
                    </div>
                </div>
                
            </div>
        </form>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4">
    @if(isset($query) && $query)
        <!-- Search Results Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-3 sm:mb-4">
                <div>
                    <h2 class="text-xl sm:text-2xl font-semibold text-secondary-900 mb-2">
                        Kết quả tìm kiếm cho: <span class="text-primary-600">"{{ $query }}"</span>
                    </h2>
                    @if(isset($posts) && $posts->total() > 0)
                        <p class="text-sm sm:text-base text-secondary-600">
                            Tìm thấy <span class="font-semibold text-secondary-900">{{ $posts->total() }}</span> kết quả
                            @if(request('category'))
                                trong chuyên mục <span class="font-semibold">{{ $categories->find(request('category'))->name ?? '' }}</span>
                            @endif
                        </p>
                    @endif
                </div>
                
                <!-- Sort Options -->
                <div class="flex items-center space-x-2 sm:space-x-4 mt-3 md:mt-0">
                    <span class="text-xs sm:text-sm text-secondary-600">Sắp xếp:</span>
                    <select onchange="updateSort(this.value)" class="text-xs sm:text-sm text-secondary-900 dark:text-primary-100-dark border border-secondary-300 dark:border-primary-700-dark rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 bg-white dark:bg-primary-900-dark focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-700-dark focus:border-primary-500 dark:focus:border-primary-700-dark">
                        @if(isset($sortOptions))
                            @foreach($sortOptions as $value => $label)
                                <option value="{{ $value }}" {{ request('sort') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        @else
                            <option value="relevance" {{ request('sort') == 'relevance' ? 'selected' : '' }}>Liên quan nhất</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến</option>
                            <option value="most_viewed" {{ request('sort') == 'most_viewed' ? 'selected' : '' }}>Xem nhiều nhất</option>
                            <option value="most_commented" {{ request('sort') == 'most_commented' ? 'selected' : '' }}>Bình luận nhiều nhất</option>
                        @endif
                    </select>
                </div>
            </div>
            
            <!-- Search Filters -->
            <div class="flex flex-wrap items-center gap-2">
                @if(request('q'))
                    <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-primary-100 text-primary-800">
                        "{{ request('q') }}"
                        <a href="?{{ http_build_query(request()->except('q')) }}" class="ml-1 sm:ml-2 text-primary-600 hover:text-primary-800">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                @endif
                
                @if(request('category'))
                    <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-primary-100 text-primary-800">
                        {{ $categories->find(request('category'))->name ?? '' }}
                        <a href="?{{ http_build_query(request()->except('category')) }}" class="ml-1 sm:ml-2 text-primary-600 hover:text-primary-800">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                @endif
                
                @if(request('author'))
                    <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-blue-100 text-blue-800">
                        {{ $authors->find(request('author'))->name ?? '' }}
                        <a href="?{{ http_build_query(request()->except('author')) }}" class="ml-1 sm:ml-2 text-blue-600 hover:text-blue-800">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                @endif
                
                @if(request('date_from'))
                    <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-purple-100 text-purple-800">
                        Từ: {{ request('date_from') }}
                        <a href="?{{ http_build_query(request()->except('date_from')) }}" class="ml-1 sm:ml-2 text-purple-600 hover:text-purple-800">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                @endif
                
                @if(request('date_to'))
                    <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-purple-100 text-purple-800">
                        Đến: {{ request('date_to') }}
                        <a href="?{{ http_build_query(request()->except('date_to')) }}" class="ml-1 sm:ml-2 text-purple-600 hover:text-purple-800">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                @endif
                
                
                @if(request()->anyFilled(['q', 'category', 'author', 'date_from', 'date_to']))
                    <a href="{{ route('search') }}" class="text-xs sm:text-sm text-secondary-600 hover:text-secondary-800 underline">
                        Xóa tất cả bộ lọc
                    </a>
                @endif
            </div>
        </div>

        @if(isset($posts) && $posts->count() > 0)
            <!-- Search Results -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
                <!-- Results List -->
                <div class="lg:col-span-2 space-y-4 sm:space-y-6">
                    @foreach($posts as $index => $post)
                        <article class="bg-white rounded-xl shadow-sm border border-secondary-200 p-4 sm:p-6 hover:shadow-md transition-shadow duration-300">
                            <div class="flex items-start space-x-3 sm:space-x-4">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-primary-100 to-primary-200 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ $post->main_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1 sm:mb-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-medium bg-{{ $post->category->color ?? 'primary' }}-100 text-{{ $post->category->color ?? 'primary' }}-800">
                                            {{ $post->category->name }}
                                        </span>
                                        <time class="text-xs sm:text-sm text-secondary-500">
                                            {{ $post->created_at->format('d/m/Y') }}
                                        </time>
                                    </div>
                                    
                                    <h3 class="text-base sm:text-xl font-semibold text-secondary-900 mb-1 sm:mb-2 line-clamp-2">
                                        <a href="{{ route('posts.show', $post->slug ?? $post->id) }}" class="hover:text-primary-600 transition-colors duration-200">
                                            {!! $post->highlighted_title ?? $post->title !!}
                                        </a>
                                    </h3>
                                    
                                    <p class="text-xs sm:text-sm text-secondary-700 mb-2 sm:mb-3 line-clamp-2 sm:line-clamp-3">
                                        {!! $post->highlighted_excerpt ?? ($post->excerpt ?? Str::limit(strip_tags($post->content), 150)) !!}
                                    </p>
                                    
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                        <div class="flex items-center flex-wrap gap-2 sm:gap-3 text-xs sm:text-sm text-secondary-600">
                                            <span class="flex items-center">
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                {{ $post->user->name }}
                                            </span>
                                            
                                            <span class="hidden sm:inline">•</span>
                                            
                                            <span class="flex items-center">
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                {{ number_format($post->view_count ?? 0) }}
                                            </span>
                                            
                                            @if($post->comments_count > 0)
                                                <span class="hidden sm:inline">•</span>
                                                <span class="flex items-center">
                                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                    </svg>
                                                    {{ $post->comments_count }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <a href="{{ route('posts.show', $post->slug ?? $post->id) }}" class="text-primary-600 hover:text-primary-700 font-medium text-xs sm:text-sm whitespace-nowrap">
                                            Đọc tiếp →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                    
                    <!-- Pagination -->
                    @if($posts->hasPages())
                        <div class="mt-6 sm:mt-8">
                            {{ $posts->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-4 sm:space-y-6">
                    <!-- Popular Categories -->
                    <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-semibold text-secondary-900 mb-3 sm:mb-4 flex items-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            Chuyên mục phổ biến
                        </h3>
                        
                        <div class="space-y-2 sm:space-y-3">
                            @if(isset($categories))
                                @foreach($categories->take(6) as $category)
                                    <a href="?{{ http_build_query(array_merge(request()->query(), ['category' => $category->id])) }}" 
                                       class="flex items-center justify-between p-2 sm:p-3 rounded-lg hover:bg-secondary-50 transition-colors duration-200 {{ request('category') == $category->id ? 'bg-primary-50 border border-primary-200' : '' }}">
                                        <span class="text-xs sm:text-sm text-secondary-700 {{ request('category') == $category->id ? 'text-primary-700 font-medium' : '' }} truncate">
                                            {{ $category->name }}
                                        </span>
                                        <span class="text-[10px] sm:text-xs text-secondary-500 bg-secondary-100 px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-full ml-2 flex-shrink-0">
                                            {{ $category->posts_count ?? 0 }}
                                        </span>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    
                    <!-- Popular Authors -->
                    @if(isset($authors) && $authors->count() > 0)
                        <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-4 sm:p-6">
                            <h3 class="text-base sm:text-lg font-semibold text-secondary-900 mb-3 sm:mb-4 flex items-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Tác giả nổi bật
                            </h3>
                            
                            <div class="space-y-2 sm:space-y-3">
                                @foreach($authors->take(5) as $author)
                                    <a href="?{{ http_build_query(array_merge(request()->query(), ['author' => $author->id])) }}" 
                                       class="flex items-center justify-between p-2 sm:p-3 rounded-lg hover:bg-secondary-50 transition-colors duration-200 {{ request('author') == $author->id ? 'bg-blue-50 border border-blue-200' : '' }}">
                                        <span class="text-xs sm:text-sm text-secondary-700 {{ request('author') == $author->id ? 'text-blue-700 font-medium' : '' }} truncate">
                                            {{ $author->name }}
                                        </span>
                                        <span class="text-[10px] sm:text-xs text-secondary-500 bg-secondary-100 px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-full ml-2 flex-shrink-0">
                                            {{ $author->posts_count ?? 0 }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Recent Searches -->
                    <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-semibold text-secondary-900 mb-3 sm:mb-4 flex items-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Tìm kiếm gần đây
                        </h3>
                        
                        <div class="space-y-2" id="recentSearches">
                            <!-- This will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- No Results -->
            <div class="text-center py-12 sm:py-16">
                <svg class="w-16 h-16 sm:w-24 sm:h-24 text-secondary-400 mx-auto mb-4 sm:mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                
                <h3 class="text-xl sm:text-2xl font-semibold text-secondary-900 mb-3 sm:mb-4 px-4">
                    Không tìm thấy kết quả nào
                </h3>
                <p class="text-sm sm:text-base text-secondary-600 mb-6 sm:mb-8 max-w-md mx-auto px-4">
                    Không có nội dung nào phù hợp với từ khóa "{{ $query }}". 
                    Hãy thử tìm kiếm với từ khóa khác hoặc mở rộng phạm vi tìm kiếm.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center space-y-3 sm:space-y-0 sm:space-x-4 px-4">
                    <button onclick="document.querySelector('input[name=q]').value=''; document.querySelector('select[name=category]').value=''; document.querySelector('form').submit();" class="btn-primary w-full sm:w-auto">
                        Xóa bộ lọc và tìm lại
                    </button>
                    <a href="{{ route('home') }}" class="btn-secondary w-full sm:w-auto">
                        Về trang chủ
                    </a>
                </div>
            </div>
        @endif
    @else
        <!-- No Search Query -->
        <div class="text-center py-12 sm:py-16">
            <svg class="w-16 h-16 sm:w-24 sm:h-24 text-secondary-400 mx-auto mb-4 sm:mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            
            <h3 class="text-xl sm:text-2xl font-semibold text-secondary-900 mb-3 sm:mb-4 px-4">
                Bắt đầu tìm kiếm
            </h3>
            <p class="text-sm sm:text-base text-secondary-600 mb-6 sm:mb-8 max-w-md mx-auto px-4">
                Nhập từ khóa vào ô tìm kiếm ở trên để khám phá nội dung phù hợp với bạn.
            </p>
            
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="q"]');
    const searchForm = document.querySelector('form');
    
    searchInput.addEventListener('input', function() {
        console.log('Searching for:', this.value);
    });
    
    if (searchInput.value) {
        saveRecentSearch(searchInput.value);
        displayRecentSearches();
    }
    
    window.updateSort = function(sortValue) {
        const url = new URL(window.location);
        url.searchParams.set('sort', sortValue);
        window.location.href = url.toString();
    };
    
    function saveRecentSearch(query) {
        let recent = JSON.parse(localStorage.getItem('recentSearches') || '[]');
        recent = recent.filter(item => item !== query);
        recent.unshift(query);
        recent = recent.slice(0, 5);
        localStorage.setItem('recentSearches', JSON.stringify(recent));
    }
    
    function displayRecentSearches() {
        const recent = JSON.parse(localStorage.getItem('recentSearches') || '[]');
        const container = document.getElementById('recentSearches');
        
        if (recent.length === 0) {
            container.innerHTML = '<p class="text-sm text-secondary-500">Chưa có tìm kiếm gần đây</p>';
            return;
        }
        
        container.innerHTML = recent.map(query => `
            <a href="?q=${encodeURIComponent(query)}" class="flex items-center justify-between p-2 text-sm text-secondary-700 hover:bg-secondary-50 rounded-lg transition-colors duration-200">
                <span>${query}</span>
                <svg class="w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        `).join('');
    }
    
    displayRecentSearches();
    
    function highlightText() {
        const query = searchInput.value;
        if (!query) return;
        
        const results = document.querySelectorAll('h3 a, .text-secondary-700');
        results.forEach(element => {
            if (element.innerHTML.includes(query)) {
                element.innerHTML = element.innerHTML.replace(
                    new RegExp(query, 'gi'),
                    `<mark class="bg-yellow-200 text-secondary-900 px-1 rounded">$&</mark>`
                );
            }
        });
    }
    
    if (searchInput.value) {
        console.log('Search query:', searchInput.value);
    }
});
</script>

@endsection
