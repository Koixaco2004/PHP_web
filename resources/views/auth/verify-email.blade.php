@extends('layouts.app')

@section('title', 'Xác thực Email')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Xác thực địa chỉ email
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Chúng tôi đã gửi link xác thực đến email của bạn
            </p>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            @if (session('message'))
                <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                    {{ session('message') }}
                </div>
            @endif

            <div class="text-center">
                <svg class="mx-auto h-16 w-16 text-blue-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                
                <h3 class="text-lg font-medium text-gray-900 mb-2">Kiểm tra email của bạn</h3>
                
                <p class="text-gray-600 mb-6">
                    Chúng tôi đã gửi một email xác thực đến <strong>{{ Auth::user()->email }}</strong>. 
                    Vui lòng kiểm tra hộp thư và click vào link để xác thực tài khoản.
                </p>

                <div class="space-y-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Gửi lại email xác thực
                        </button>
                    </form>

                    <div class="text-center">
                        <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:text-blue-500">
                            Quay lại trang chủ
                        </a>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-sm text-gray-600 hover:text-gray-900">
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center text-xs text-gray-500">
            <p>Không nhận được email? Kiểm tra thư mục spam hoặc click "Gửi lại email xác thực"</p>
        </div>
    </div>
</div>
@endsection
