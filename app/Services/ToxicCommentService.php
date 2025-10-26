<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Dịch vụ phân loại bình luận độc hại
 * 
 * Sử dụng API Python cục bộ để kiểm tra xem một bình luận có độc hại hay không
 */
class ToxicCommentService
{
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.toxic_api.url', 'http://127.0.0.1:5000/classify');
    }

    /**
     * Kiểm tra bình luận có phải độc hại hay không
     * 
     * @param string $content Nội dung bình luận cần kiểm tra
     * @return bool Trả về true nếu độc hại, false nếu không độc hại
     */
    public function isToxic(string $content): bool
    {
        try {
            $response = Http::timeout(10)->post($this->apiUrl, [
                'text' => $content,
            ]);

            // Nếu gọi API thất bại, mặc định cho phép (không xem là độc hại)
            if (!$response->successful()) {
                Log::warning('Toxic API call failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return false;
            }

            $result = $response->json();

            // Kiểm tra phản hồi từ API có hợp lệ không
            if (empty($result) || !isset($result['success']) || !$result['success']) {
                Log::warning('Invalid response from Toxic API', ['result' => $result]);
                return false;
            }

            $isToxic = $result['is_toxic'] ?? false;
            $label = $result['label'] ?? 'unknown';
            $score = $result['score'] ?? 0;

            Log::info('Comment classified', [
                'label' => $label,
                'score' => $score,
                'is_toxic' => $isToxic,
            ]);

            return $isToxic;
        } catch (\Exception $e) {
            // Nếu xảy ra lỗi, ghi log và mặc định không xem là độc hại
            Log::error('Error classifying comment', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }
}
