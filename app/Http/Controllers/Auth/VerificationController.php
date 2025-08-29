<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Hiển thị trang yêu cầu xác thực email
     */
    public function notice()
    {
        return view('auth.verify-email');
    }

    /**
     * Xử lý xác thực email
     */
    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/')->with('message', 'Email của bạn đã được xác thực.');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect('/')->with('message', 'Email của bạn đã được xác thực thành công!');
    }

    /**
     * Gửi lại email xác thực
     */
    public function send(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return back()->with('message', 'Email của bạn đã được xác thực.');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Link xác thực đã được gửi lại!');
    }
}
