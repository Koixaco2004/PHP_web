<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Exception;

class ImgBBService
{
    private $apiKey;
    private $baseUrl = 'https://api.imgbb.com/1/upload';

    public function __construct()
    {
        $this->apiKey = config('services.imgbb.api_key');
    }

    /**
     * Upload image to ImgBB
     */
    public function uploadImage(UploadedFile $file, $name = null)
    {
        try {
            // Convert image to base64
            $imageData = base64_encode(file_get_contents($file->getRealPath()));
            
            $response = Http::asForm()->post($this->baseUrl, [
                'key' => $this->apiKey,
                'image' => $imageData,
                'name' => $name ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['success']) {
                    return [
                        'success' => true,
                        'data' => [
                            'image_url' => $data['data']['url'],
                            'delete_url' => $data['data']['delete_url'],
                            'width' => $data['data']['width'],
                            'height' => $data['data']['height'],
                            'file_size' => $data['data']['size'],
                        ]
                    ];
                }
            }

            return [
                'success' => false,
                'message' => 'Failed to upload image to ImgBB'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error uploading image: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete image from ImgBB
     */
    public function deleteImage($deleteUrl)
    {
        try {
            $response = Http::get($deleteUrl);
            return $response->successful();
        } catch (Exception $e) {
            return false;
        }
    }
}
