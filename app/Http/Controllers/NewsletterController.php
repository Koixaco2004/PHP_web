<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewsletterWelcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    /**
     * Đăng ký nhận tin
     */
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Tạo user mới cho newsletter
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => null, // Không có password cho newsletter subscription
                'role' => 'subscriber',
                'email_verified_at' => now(), // Newsletter không cần verify email
            ]);

            // Gửi email chào mừng
            $user->notify(new NewsletterWelcome());

            return response()->json([
                'success' => true,
                'message' => 'Cảm ơn bạn đã đăng ký nhận tin! Chúng tôi sẽ gửi email xác nhận cho bạn.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra. Vui lòng thử lại sau.'
            ], 500);
        }
    }

    /**
     * Hủy đăng ký nhận tin
     */
    public function unsubscribe(Request $request)
    {
        $email = $request->email;
        
        $user = User::where('email', $email)->where('role', 'subscriber')->first();
        
        if ($user) {
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'Bạn đã hủy đăng ký nhận tin thành công.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy email này trong danh sách đăng ký.'
        ], 404);
    }
}
