<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ImgBBService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TempImageController extends Controller
{
    protected $imgBBService;

    public function __construct(ImgBBService $imgBBService)
    {
        $this->imgBBService = $imgBBService;
    }

    /**
     * Upload temporary image for preview
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);

        $result = $this->imgBBService->uploadImage($request->file('image'));

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
