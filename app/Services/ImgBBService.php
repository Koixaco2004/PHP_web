<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Exception;

/**
 * Dịch vụ tải lên và quản lý hình ảnh trên ImgBB
 * 
 * Cung cấp các chức năng tải lên hình ảnh và xóa hình ảnh từ ImgBB API.
 */
class ImgBBService
{
    private $apiKey;
    private $baseUrl = 'https://api.imgbb.com/1/upload';

    /**
     * Khởi tạo dịch vụ với API key từ cấu hình ứng dụng
     */
    public function __construct()
    {
        $this->apiKey = config('services.imgbb.api_key');
    }

    /**
     * Tải lên hình ảnh lên ImgBB và trả về thông tin chi tiết
     * 
     * @param UploadedFile $file - Tệp hình ảnh cần tải lên
     * @param string|null $name - Tên tuỳ chỉnh cho hình ảnh (nếu không có sẽ dùng tên tệp gốc)
     * @return array - Mảng chứa kết quả tải lên (thành công/thất bại và dữ liệu liên quan)
     */
    public function uploadImage(UploadedFile $file, $name = null)
    {
        try {
            // Chuyển đổi hình ảnh sang định dạng Base64 để gửi qua HTTP
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
                'message' => 'Không thể tải lên hình ảnh lên ImgBB'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi khi tải lên hình ảnh: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Xóa hình ảnh khỏi ImgBB bằng URL xóa
     * 
     * @param string $deleteUrl - URL xóa được cung cấp từ ImgBB
     * @return bool - Trả về true nếu xóa thành công, false nếu thất bại
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
