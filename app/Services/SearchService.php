<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchService
{
    /**
     * Thực hiện tìm kiếm với các bộ lọc
     *
     * Tìm kiếm các bài viết theo từ khóa và áp dụng các bộ lọc như danh mục,
     * tác giả, trạng thái và khoảng thời gian, sau đó sắp xếp kết quả.
     *
     * @param string $query Từ khóa tìm kiếm
     * @param array $filters Mảng các bộ lọc (category, author, status, date_from, date_to, sort, per_page)
     * @return array Mảng chứa bài viết và tổng số kết quả
     */
    public function search($query, $filters = [])
    {
        $builder = Post::with(['category', 'user', 'images'])
            ->published()
            ->withActiveCategory();

        if (!empty($query)) {
            $builder = $this->applySearchQuery($builder, $query);
        }

        $builder = $this->applyFilters($builder, $filters);

        $builder = $this->applySorting($builder, $filters['sort'] ?? 'relevance', $query);

        $perPage = $filters['per_page'] ?? 10;
        $posts = $builder->paginate($perPage);

        return [
            'posts' => $posts,
            'total' => $posts->total(),
        ];
    }

    /**
     * Áp dụng từ khóa tìm kiếm vào truy vấn
     *
     * Phân tích từ khóa và tìm kiếm trong các trường tiêu đề, nội dung và tóm tắt.
     *
     * @param Builder $builder Truy vấn builder
     * @param string $query Từ khóa tìm kiếm
     * @return Builder Truy vấn đã được sửa đổi
     */
    private function applySearchQuery(Builder $builder, string $query): Builder
    {
        $searchTerms = $this->parseSearchTerms($query);

        // Tìm kiếm từng từ khóa trong các trường với logic OR
        return $builder->where(function ($q) use ($searchTerms) {
            foreach ($searchTerms as $term) {
                $q->orWhere(function ($subQuery) use ($term) {
                    $subQuery->where('title', 'like', "%{$term}%")
                        ->orWhere('content', 'like', "%{$term}%")
                        ->orWhere('excerpt', 'like', "%{$term}%");
                });
            }
        });
    }

    /**
     * Áp dụng các bộ lọc vào truy vấn
     *
     * Lọc bài viết theo danh mục, tác giả, và khoảng thời gian đăng bài.
     *
     * @param Builder $builder Truy vấn builder
     * @param array $filters Mảng các bộ lọc
     * @return Builder Truy vấn đã được sửa đổi
     */
    private function applyFilters(Builder $builder, array $filters): Builder
    {
        if (!empty($filters['category'])) {
            $builder->where('category_id', $filters['category']);
        }

        if (!empty($filters['author'])) {
            $builder->where('user_id', $filters['author']);
        }

        if (!empty($filters['date_from'])) {
            $builder->whereDate('published_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $builder->whereDate('published_at', '<=', $filters['date_to']);
        }

        return $builder;
    }

    /**
     * Áp dụng sắp xếp kết quả tìm kiếm
     *
     * Sắp xếp bài viết theo tiêu chí được chỉ định (mới nhất, cũ nhất, phổ biến, v.v.).
     *
     * @param Builder $builder Truy vấn builder
     * @param string $sort Kiểu sắp xếp
     * @param string|null $query Từ khóa tìm kiếm (dùng cho sắp xếp theo liên quan)
     * @return Builder Truy vấn đã được sửa đổi
     */
    private function applySorting(Builder $builder, string $sort, ?string $query = null): Builder
    {
        switch ($sort) {
            case 'newest':
                return $builder->latest('published_at');

            case 'oldest':
                return $builder->oldest('published_at');

            case 'popular':
                return $builder->orderByDesc('view_count')
                    ->orderByDesc('comment_count')
                    ->latest('published_at');

            case 'most_viewed':
                return $builder->orderByDesc('view_count')
                    ->latest('published_at');

            case 'most_commented':
                return $builder->orderByDesc('comment_count')
                    ->latest('published_at');

            case 'relevance':
            default:
                return $this->applyRelevanceSorting($builder, $query);
        }
    }

    /**
     * Áp dụng sắp xếp dựa trên độ liên quan
     *
     * Tính điểm liên quan dựa trên vị trí từ khóa xuất hiện (tiêu đề được ưu tiên cao hơn).
     * Các từ khóa xuất hiện trước có trọng số lớn hơn.
     *
     * @param Builder $builder Truy vấn builder
     * @param string|null $query Từ khóa tìm kiếm
     * @return Builder Truy vấn đã được sửa đổi
     */
    private function applyRelevanceSorting(Builder $builder, ?string $query): Builder
    {
        if (empty($query)) {
            return $builder->latest('published_at');
        }

        $searchTerms = $this->parseSearchTerms($query);

        // Xây dựng công thức tính điểm liên quan bằng CASE WHEN
        // Tiêu đề có trọng số 3x, tóm tắt 2x, nội dung 1x
        $relevanceScore = 'CASE ';
        foreach ($searchTerms as $index => $term) {
            $weight = count($searchTerms) - $index;
            $relevanceScore .= "WHEN title LIKE '%{$term}%' THEN " . ($weight * 3) . " ";
            $relevanceScore .= "WHEN excerpt LIKE '%{$term}%' THEN " . ($weight * 2) . " ";
            $relevanceScore .= "WHEN content LIKE '%{$term}%' THEN {$weight} ";
        }
        $relevanceScore .= 'ELSE 0 END';

        return $builder->selectRaw("*, ({$relevanceScore}) as relevance_score")
            ->orderByDesc('relevance_score')
            ->orderByDesc('view_count')
            ->latest('published_at');
    }

    /**
     * Phân tích từ khóa tìm kiếm
     *
     * Tách từ khóa, loại bỏ các từ dừng phổ biến và các từ quá ngắn.
     *
     * @param string $query Chuỗi từ khóa
     * @return array Mảng các từ khóa hợp lệ
     */
    private function parseSearchTerms(string $query): array
    {
        $terms = array_filter(explode(' ', trim($query)));

        $stopWords = ['và', 'của', 'cho', 'với', 'từ', 'đến', 'trong', 'ngoài', 'trên', 'dưới', 'theo', 'như', 'là', 'có', 'được', 'sẽ', 'đã', 'đang'];

        return array_filter($terms, function ($term) use ($stopWords) {
            return !in_array(mb_strtolower($term), $stopWords) && strlen($term) > 1;
        });
    }

    /**
     * Lấy các tùy chọn lọc cho biểu mẫu tìm kiếm
     *
     * Trả về danh mục hoạt động và các tác giả có bài viết đã được phê duyệt.
     *
     * @return array Mảng chứa danh mục và tác giả
     */
    public function getFilterOptions()
    {
        return [
            'categories' => Category::active()
                ->withCount(['posts' => function ($query) {
                    $query->published();
                }])
                ->orderBy('posts_count', 'desc')
                ->get(),

            'authors' => User::whereHas('posts', function ($query) {
                $query->published();
            })
                ->withCount(['posts' => function ($query) {
                    $query->published();
                }])
                ->orderBy('posts_count', 'desc')
                ->limit(20)
                ->get(),
        ];
    }

    /**
     * Lấy gợi ý tìm kiếm để tự động hoàn thành
     *
     * Trả về danh sách gợi ý dựa trên tiêu đề bài viết và tên danh mục.
     *
     * @param string $query Từ khóa để tìm gợi ý
     * @return array Mảng các gợi ý
     */
    public function getSuggestions(string $query): array
    {
        if (strlen($query) < 2) {
            return [];
        }

        $suggestions = [];

        // Lấy gợi ý từ tiêu đề bài viết
        $titleSuggestions = Post::published()
            ->where('title', 'like', "%{$query}%")
            ->select('title')
            ->distinct()
            ->limit(5)
            ->get()
            ->pluck('title')
            ->toArray();

        $suggestions = array_merge($suggestions, $titleSuggestions);

        // Lấy gợi ý từ danh mục
        $categorySuggestions = Category::active()
            ->where('name', 'like', "%{$query}%")
            ->limit(3)
            ->get()
            ->pluck('name')
            ->toArray();

        $suggestions = array_merge($suggestions, $categorySuggestions);

        // Loại bỏ trùng lặp và giới hạn số lượng gợi ý
        $suggestions = array_unique($suggestions);
        $suggestions = array_slice($suggestions, 0, 8);

        return $suggestions;
    }

    /**
     * Lấy danh sách các từ khóa tìm kiếm phổ biến
     *
     * Trả về các từ khóa được tìm kiếm nhiều để hiển thị cho người dùng.
     *
     * @return array Mảng các từ khóa phổ biến
     */
    public function getPopularSearchTerms(): array
    {
        return [
            'công nghệ',
            'kinh doanh',
            'giáo dục',
            'sức khỏe',
            'du lịch',
            'ẩm thực',
            'thể thao',
            'giải trí',
        ];
    }

    /**
     * Lấy bài viết xu hướng dựa trên lượt xem và tương tác gần đây
     *
     * Trả về các bài viết đã được phê duyệt trong 7 ngày gần đây với lượt xem
     * và bình luận cao nhất.
     *
     * @param int $limit Số bài viết tối đa cần lấy
     * @return mixed Danh sách bài viết xu hướng
     */
    public function getTrendingPosts(int $limit = 5)
    {
        return Post::published()
            ->withActiveCategory()
            ->with(['category', 'user'])
            ->where('published_at', '>=', now()->subDays(7))
            ->orderByDesc('view_count')
            ->orderByDesc('comment_count')
            ->limit($limit)
            ->get();
    }

    /**
     * Lấy bài viết liên quan dựa trên danh mục
     *
     * Trả về các bài viết trong cùng danh mục, không bao gồm bài gốc.
     *
     * @param Post $post Bài viết gốc
     * @param int $limit Số bài viết liên quan tối đa
     * @return mixed Danh sách bài viết liên quan
     */
    public function getRelatedPosts(Post $post, int $limit = 5)
    {
        return Post::published()
            ->withActiveCategory()
            ->with(['category', 'user'])
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }
}
