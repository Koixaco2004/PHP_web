<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ImgBBService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Quản lý tải lên hình ảnh tạm thời cho chức năng xem trước.
 * 
 * Lớp này xử lý việc nhận, xác thực và tải hình ảnh lên dịch vụ ImgBB.
 */
class TempImageController extends Controller
{
    protected $imgBBService;

    /**
     * Khởi tạo controller với dịch vụ ImgBB.
     * 
     * @param ImgBBService $imgBBService Dịch vụ xử lý tải lên hình ảnh
     */
    public function __construct(ImgBBService $imgBBService)
    {
        $this->imgBBService = $imgBBService;
    }

    /**
     * Tải lên hình ảnh tạm thời và trả về URL để xem trước.
     * 
     * Xác thực hình ảnh đầu vào (định dạng, kích thước) rồi tải lên ImgBB.
     * Trả về đường dẫn hình ảnh hoặc thông báo lỗi tương ứng.
     * 
     * @param Request $request Yêu cầu HTTP chứa file hình ảnh
     * @return JsonResponse Phản hồi JSON với kết quả tải lên
     */
    public function upload(Request $request): JsonResponse
    {
        // Xác thực hình ảnh: bắt buộc, định dạng hợp lệ, kích thước tối đa 5MB
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $result = $this->imgBBService->uploadImage($request->file('image'));

        // Kiểm tra kết quả tải lên và trả về phản hồi tương ứng
        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully',
                'data' => $result['data']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message']
        ], 400);
    }
}
