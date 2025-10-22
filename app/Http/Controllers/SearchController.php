<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * Display the search page and handle search requests.
     */
    public function index(Request $request)
    {
        $query = $request->get('q');
        $filters = $this->extractFilters($request);
        
        // Get search results
        $searchResults = $this->searchService->search($query, $filters);
        
        // Format search results with highlighting
        if (!empty($query)) {
            $searchResults['posts'] = formatSearchResults($searchResults['posts'], $query);
        }
        
        // Get filter options
        $filterOptions = $this->searchService->getFilterOptions();
        
        // Prepare data for view
        $data = [
            'query' => $query,
            'posts' => $searchResults['posts'],
            'categories' => $filterOptions['categories'],
            'authors' => $filterOptions['authors'],
            'totalResults' => $searchResults['total'],
            'filters' => $filters,
            'sortOptions' => $this->getSortOptions(),
        ];

        return view('search.index', $data);
    }

    /**
     * Handle AJAX search requests for real-time suggestions.
     */
    public function suggest(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = $this->searchService->getSuggestions($query);
        
        return response()->json($suggestions);
    }

    /**
     * Get popular search terms.
     */
    public function popular()
    {
        $popularTerms = $this->searchService->getPopularSearchTerms();
        
        return response()->json($popularTerms);
    }

    /**
     * Extract and validate filters from request.
     */
    private function extractFilters(Request $request)
    {
        return [
            'category' => $request->get('category'),
            'author' => $request->get('author'),
            'status' => $request->get('status'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
            'sort' => $request->get('sort', 'relevance'),
            'per_page' => $request->get('per_page', 10),
        ];
    }

    /**
     * Get available sort options.
     */
    private function getSortOptions()
    {
        return [
            'relevance' => 'Liên quan nhất',
            'newest' => 'Mới nhất',
            'oldest' => 'Cũ nhất',
            'popular' => 'Phổ biến nhất',
            'most_viewed' => 'Xem nhiều nhất',
            'most_commented' => 'Bình luận nhiều nhất',
        ];
    }
}
