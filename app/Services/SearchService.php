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
     * Perform search with filters.
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
     * Apply search query to builder.
     */
    private function applySearchQuery(Builder $builder, string $query): Builder
    {
        $searchTerms = $this->parseSearchTerms($query);

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
     * Apply filters to builder.
     */
    private function applyFilters(Builder $builder, array $filters): Builder
    {
        if (!empty($filters['category'])) {
            $builder->where('category_id', $filters['category']);
        }

        if (!empty($filters['author'])) {
            $builder->where('user_id', $filters['author']);
        }

        if (!empty($filters['status']) && Auth::check() && Auth::user()->role === 'admin') {
            if ($filters['status'] === 'draft') {
                $builder->where('status', 'draft');
            } elseif ($filters['status'] === 'published') {
                $builder->where('status', 'published');
            }
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
     * Apply sorting to builder.
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
     * Apply relevance-based sorting.
     */
    private function applyRelevanceSorting(Builder $builder, ?string $query): Builder
    {
        if (empty($query)) {
            return $builder->latest('published_at');
        }

        $searchTerms = $this->parseSearchTerms($query);

        // Create relevance scoring
        $relevanceScore = 'CASE ';
        foreach ($searchTerms as $index => $term) {
            $weight = count($searchTerms) - $index; // Higher weight for first terms
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
     * Parse search terms from query string.
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
     * Get filter options for the search form.
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
     * Get search suggestions for autocomplete.
     */
    public function getSuggestions(string $query): array
    {
        if (strlen($query) < 2) {
            return [];
        }

        $suggestions = [];

        // Get title suggestions
        $titleSuggestions = Post::published()
            ->where('title', 'like', "%{$query}%")
            ->select('title')
            ->distinct()
            ->limit(5)
            ->get()
            ->pluck('title')
            ->toArray();

        $suggestions = array_merge($suggestions, $titleSuggestions);

        $categorySuggestions = Category::active()
            ->where('name', 'like', "%{$query}%")
            ->limit(3)
            ->get()
            ->pluck('name')
            ->toArray();

        $suggestions = array_merge($suggestions, $categorySuggestions);

        $suggestions = array_unique($suggestions);
        $suggestions = array_slice($suggestions, 0, 8);

        return $suggestions;
    }

    /**
     * Get popular search terms (mock implementation).
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
     * Get trending posts based on recent views and engagement.
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
     * Get related posts based on category and tags.
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
