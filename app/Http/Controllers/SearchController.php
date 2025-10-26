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
     * Hiển thị trang tìm kiếm và xử lý yêu cầu tìm kiếm.
     */
    public function index(Request $request)
    {
        $query = $request->get('q');
        $filters = $this->extractFilters($request);

        // Lấy kết quả tìm kiếm
        $searchResults = $this->searchService->search($query, $filters);

        // Định dạng kết quả tìm kiếm với việc làm nổi bật
        if (!empty($query)) {
            $searchResults['posts'] = formatSearchResults($searchResults['posts'], $query);
        }

        // Lấy tùy chọn bộ lọc
        $filterOptions = $this->searchService->getFilterOptions();

        // Chuẩn bị dữ liệu cho view
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
     * Xử lý yêu cầu tìm kiếm AJAX cho gợi ý thời gian thực.
     */
    public function suggest(Request $request)
    {
        $query = $request->get('q');

        if (empty($query) || strlen($query) < 2) {
            return response()->json([]); // Nếu truy vấn quá ngắn, trả về rỗng
        }

        $suggestions = $this->searchService->getSuggestions($query);

        return response()->json($suggestions);
    }

    /**
     * Lấy các từ khóa tìm kiếm phổ biến.
     */
    public function popular()
    {
        $popularTerms = $this->searchService->getPopularSearchTerms();

        return response()->json($popularTerms);
    }

    /**
     * Trích xuất và xác thực bộ lọc từ yêu cầu.
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
     * Lấy các tùy chọn sắp xếp có sẵn.
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
