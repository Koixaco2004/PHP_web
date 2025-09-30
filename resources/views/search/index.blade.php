@extends('layouts.app')

@section('title', 'Tìm kiếm - ' . ($query ?? ''))

@section('content')
<!-- Search Header -->
<div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-xl shadow-lg p-8 mb-8 animate-slide-up">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-6">
            <h1 class="text-4xl font-heading font-bold text-white mb-4">
                Tìm kiếm nội dung
            </h1>
            <p class="text-primary-100 text-lg">
                Khám phá hàng ngàn bài viết chất lượng với công cụ tìm kiếm thông minh
            </p>
        </div>
        
        <!-- Search Form -->
        <form method="GET" action="{{ route('search') ?? request()->url() }}" class="relative">
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-6 h-6 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           name="q" 
                           value="{{ $query ?? request('q') }}" 
                           placeholder="Nhập từ khóa tìm kiếm..." 
                           class="block w-full pl-12 pr-4 py-4 text-lg border border-secondary-300 rounded-xl bg-white focus:ring-2 focus:ring-white focus:border-white transition-colors duration-200"
                           autocomplete="off"
                           autofocus>
                </div>
                
                <div class="flex space-x-2">
                    <select name="category" class="px-4 py-4 border border-secondary-300 rounded-xl bg-white focus:ring-2 focus:ring-white focus:border-white transition-colors duration-200">
                        <option value="">Tất cả chuyên mục</option>
                        @if(isset($categories))
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    
                    <button type="submit" class="px-8 py-4 bg-white text-primary-600 font-semibold rounded-xl hover:bg-secondary-50 transition-colors duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Tìm kiếm
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4">
    @if(isset($query) && $query)
        <!-- Search Results Header -->
        <div class="mb-8 animate-fade-in">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                <div>
                    <h2 class="text-2xl font-semibold text-secondary-900 mb-2">
                        Kết quả tìm kiếm cho: <span class="text-primary-600">"{{ $query }}"</span>
                    </h2>
                    @if(isset($posts) && $posts->total() > 0)
                        <p class="text-secondary-600">
                            Tìm thấy <span class="font-semibold text-secondary-900">{{ $posts->total() }}</span> kết quả
                            @if(request('category'))
                                trong chuyên mục <span class="font-semibold">{{ $categories->find(request('category'))->name ?? '' }}</span>
                            @endif
                        </p>
                    @endif
                </div>
                
                <!-- Sort Options -->
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <span class="text-sm text-secondary-600">Sắp xếp:</span>
                    <select onchange="updateSort(this.value)" class="text-sm border border-secondary-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="relevance" {{ request('sort') == 'relevance' ? 'selected' : '' }}>Liên quan nhất</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến</option>
                    </select>
                </div>
            </div>
            
            <!-- Search Filters -->
            <div class="flex flex-wrap items-center space-x-2 space-y-2">
                @if(request('q'))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800">
                        "{{ request('q') }}"
                        <a href="?{{ http_build_query(request()->except('q')) }}" class="ml-2 text-primary-600 hover:text-primary-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                @endif
                
                @if(request('category'))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        {{ $categories->find(request('category'))->name ?? '' }}
                        <a href="?{{ http_build_query(request()->except('category')) }}" class="ml-2 text-green-600 hover:text-green-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                @endif
                
                @if(request()->anyFilled(['q', 'category']))
                    <a href="{{ route('search') ?? request()->url() }}" class="text-sm text-secondary-600 hover:text-secondary-800 underline">
                        Xóa tất cả bộ lọc
                    </a>
                @endif
            </div>
        </div>

        @if(isset($posts) && $posts->count() > 0)
            <!-- Search Results -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Results List -->
                <div class="lg:col-span-2 space-y-6">
                    @foreach($posts as $index => $post)
                        <article class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 hover:shadow-md transition-shadow duration-300 animate-slide-up" style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="flex items-start space-x-4">
                                <div class="w-20 h-20 bg-gradient-to-br from-primary-100 to-primary-200 rounded-lg overflow-hidden flex-shrink-0">
                                    @if($post->main_image)
                                        <img src="{{ $post->main_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $post->category->color ?? 'primary' }}-100 text-{{ $post->category->color ?? 'primary' }}-800">
                                            {{ $post->category->name }}
                                        </span>
                                        <time class="text-sm text-secondary-500">
                                            {{ $post->created_at->format('d/m/Y') }}
                                        </time>
                                    </div>
                                    
                                    <h3 class="text-xl font-semibold text-secondary-900 mb-2 line-clamp-2">
                                        <a href="{{ route('posts.show', $post->slug ?? $post->id) }}" class="hover:text-primary-600 transition-colors duration-200">
                                            {!! highlightSearchTerm($post->title, $query) !!}
                                        </a>
                                    </h3>
                                    
                                    <p class="text-secondary-700 mb-3 line-clamp-3">
                                        {!! highlightSearchTerm($post->excerpt ?? Str::limit(strip_tags($post->content), 150), $query) !!}
                                    </p>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center text-sm text-secondary-600">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            {{ $post->user->name }}
                                            
                                            <span class="mx-2">•</span>
                                            
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            {{ $post->views ?? 0 }} lượt xem
                                            
                                            @if($post->comments_count > 0)
                                                <span class="mx-2">•</span>
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                </svg>
                                                {{ $post->comments_count }} bình luận
                                            @endif
                                        </div>
                                        
                                        <a href="{{ route('posts.show', $post->slug ?? $post->id) }}" class="text-primary-600 hover:text-primary-700 font-medium text-sm">
                                            Đọc tiếp →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                    
                    <!-- Pagination -->
                    @if($posts->hasPages())
                        <div class="mt-8">
                            {{ $posts->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Popular Categories -->
                    <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 animate-slide-up" style="animation-delay: 0.2s">
                        <h3 class="text-lg font-semibold text-secondary-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            Chuyên mục phổ biến
                        </h3>
                        
                        <div class="space-y-3">
                            @if(isset($categories))
                                @foreach($categories->take(6) as $category)
                                    <a href="?{{ http_build_query(array_merge(request()->query(), ['category' => $category->id])) }}" 
                                       class="flex items-center justify-between p-3 rounded-lg hover:bg-secondary-50 transition-colors duration-200 {{ request('category') == $category->id ? 'bg-primary-50 border border-primary-200' : '' }}">
                                        <span class="text-secondary-700 {{ request('category') == $category->id ? 'text-primary-700 font-medium' : '' }}">
                                            {{ $category->name }}
                                        </span>
                                        <span class="text-xs text-secondary-500 bg-secondary-100 px-2 py-1 rounded-full">
                                            {{ $category->posts_count ?? 0 }}
                                        </span>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    
                    <!-- Search Tips -->
                    <div class="bg-gradient-to-br from-accent-50 to-accent-100 rounded-xl p-6 animate-slide-up" style="animation-delay: 0.4s">
                        <h3 class="text-lg font-semibold text-accent-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-accent-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            Mẹo tìm kiếm
                        </h3>
                        
                        <ul class="space-y-3 text-sm text-accent-800">
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-accent-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Sử dụng từ khóa cụ thể để có kết quả chính xác hơn
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-accent-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Kết hợp với chuyên mục để lọc kết quả theo lĩnh vực
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-accent-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Thử các từ đồng nghĩa nếu không tìm thấy kết quả
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-accent-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Sắp xếp theo mức độ liên quan hoặc thời gian
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Recent Searches -->
                    <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 animate-slide-up" style="animation-delay: 0.6s">
                        <h3 class="text-lg font-semibold text-secondary-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div class="text-center py-16 animate-fade-in">
                <svg class="w-24 h-24 text-secondary-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                
                <h3 class="text-2xl font-semibold text-secondary-900 mb-4">
                    Không tìm thấy kết quả nào
                </h3>
                <p class="text-secondary-600 mb-8 max-w-md mx-auto">
                    Không có nội dung nào phù hợp với từ khóa "{{ $query }}". 
                    Hãy thử tìm kiếm với từ khóa khác hoặc mở rộng phạm vi tìm kiếm.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <button onclick="document.querySelector('input[name=q]').value=''; document.querySelector('select[name=category]').value=''; document.querySelector('form').submit();" class="btn-primary">
                        Xóa bộ lọc và tìm lại
                    </button>
                    <a href="{{ route('home') }}" class="btn-secondary">
                        Về trang chủ
                    </a>
                </div>
            </div>
        @endif
    @else
        <!-- No Search Query -->
        <div class="text-center py-16">
            <svg class="w-24 h-24 text-secondary-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            
            <h3 class="text-2xl font-semibold text-secondary-900 mb-4">
                Bắt đầu tìm kiếm
            </h3>
            <p class="text-secondary-600 mb-8 max-w-md mx-auto">
                Nhập từ khóa vào ô tìm kiếm ở trên để khám phá nội dung phù hợp với bạn.
            </p>
            
            <!-- Popular Keywords -->
            <div class="max-w-2xl mx-auto">
                <h4 class="text-lg font-medium text-secondary-900 mb-4">Từ khóa phổ biến:</h4>
                <div class="flex flex-wrap justify-center gap-3">
                    @php
                        $popularKeywords = ['công nghệ', 'kinh doanh', 'giáo dục', 'sức khỏe', 'du lịch', 'ẩm thực', 'thể thao', 'giải trí'];
                    @endphp
                    @foreach($popularKeywords as $keyword)
                        <a href="?q={{ $keyword }}" class="inline-flex items-center px-4 py-2 bg-white border border-secondary-300 rounded-full text-sm text-secondary-700 hover:bg-primary-50 hover:border-primary-300 hover:text-primary-700 transition-colors duration-200">
                            {{ $keyword }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.querySelector('input[name="q"]');
    const searchForm = document.querySelector('form');
    
    // Auto-complete (simplified)
    searchInput.addEventListener('input', function() {
        // Here you could implement real-time search suggestions
        console.log('Searching for:', this.value);
    });
    
    // Save recent searches to localStorage
    if (searchInput.value) {
        saveRecentSearch(searchInput.value);
        displayRecentSearches();
    }
    
    // Sort functionality
    window.updateSort = function(sortValue) {
        const url = new URL(window.location);
        url.searchParams.set('sort', sortValue);
        window.location.href = url.toString();
    };
    
    // Recent searches functionality
    function saveRecentSearch(query) {
        let recent = JSON.parse(localStorage.getItem('recentSearches') || '[]');
        recent = recent.filter(item => item !== query); // Remove if exists
        recent.unshift(query); // Add to beginning
        recent = recent.slice(0, 5); // Keep only 5 items
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
    
    // Initialize recent searches
    displayRecentSearches();
    
    // Highlight search terms in results
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
    
    // Add search analytics (if needed)
    if (searchInput.value) {
        // Track search query
        console.log('Search query:', searchInput.value);
    }
});

// Helper function for highlighting search terms (PHP equivalent in JavaScript)
@if(isset($query) && $query)
// This would be handled by PHP function highlightSearchTerm() in the view
@endif
</script>

@if(!function_exists('highlightSearchTerm'))
@php
function highlightSearchTerm($text, $term) {
    if (!$term) return $text;
    return preg_replace('/(' . preg_quote($term, '/') . ')/i', '<mark class="bg-yellow-200 text-secondary-900 px-1 rounded">$1</mark>', $text);
}
@endphp
@endif
@endsection
