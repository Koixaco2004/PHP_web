<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ToxicCommentService
{
    private string $apiUrl;

    public function __construct()
    {
        // Use local Python API
        $this->apiUrl = config('services.toxic_api.url', 'http://127.0.0.1:5000/classify');
    }

    /**
     * Classify a comment using the local Python API
     * Returns true if toxic, false if non-toxic
     * 
     * @param string $content
     * @return bool
     */
    public function isToxic(string $content): bool
    {
        try {
            // Call local Python API
            $response = Http::timeout(10)->post($this->apiUrl, [
                'text' => $content,
            ]);

            // If API call fails, default to non-toxic
            if (!$response->successful()) {
                Log::warning('Toxic API call failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return false;
            }

            $result = $response->json();

            // Check response format
            if (empty($result) || !isset($result['success']) || !$result['success']) {
                Log::warning('Invalid response from Toxic API', ['result' => $result]);
                return false;
            }

            // Get is_toxic from response
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
            // If any error occurs, log it and default to non-toxic
            Log::error('Error classifying comment', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }
}
