@extends('layouts.app')

@section('title', 'Xác thực Email')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 via-white to-accent-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-6 sm:py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-6 sm:space-y-8">
        <!-- Logo & Header -->
        <div class="text-center">
            <div class="mx-auto h-16 w-16 sm:h-20 sm:w-20 bg-gradient-to-br from-primary-600 to-primary-700 dark:from-primary-100-dark dark:to-primary-200-dark rounded-2xl flex items-center justify-center shadow-lg">
                <svg class="h-8 w-8 sm:h-10 sm:w-10 text-white dark:text-primary-900-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="mt-4 sm:mt-6 text-2xl sm:text-3xl font-heading font-bold text-secondary-900 dark:text-primary-400-dark">Xác thực Email</h2>
            <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-secondary-600 dark:text-gray-300">Vui lòng xác thực địa chỉ email của bạn để tiếp tục</p>
        </div>

        <!-- Status Message -->
        @if (session('status'))
            <div class="bg-primary-50 dark:bg-primary-900 border border-primary-200 dark:border-primary-700 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-primary-400 dark:text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-primary-800 dark:text-primary-200">
                            {{ session('status') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Verification Notice -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-secondary-100 dark:border-gray-700 p-6 sm:p-8">
            <div class="text-center space-y-3 sm:space-y-4">
                <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark mb-2">Kiểm tra hộp thư của bạn</h3>
                    <p class="text-sm text-secondary-600 dark:text-gray-300">
                        Chúng tôi đã gửi một email xác thực đến <strong>{{ Auth::user()->email }}</strong>. 
                        Vui lòng nhấp vào link trong email để xác thực tài khoản.
                    </p>
                </div>

                <div class="pt-4">
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full inline-flex justify-center items-center px-6 py-2.5 sm:py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-primary-600 to-primary-700 dark:from-primary-100-dark dark:to-primary-200-dark hover:from-primary-700 hover:to-primary-800 dark:hover:from-primary-200-dark dark:hover:to-primary-300-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-primary-400-dark transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Gửi lại email xác thực
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Help Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-secondary-100 dark:border-gray-700 p-5 sm:p-6">
            <div class="text-center">
                <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark mb-3">Không nhận được email?</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-center text-secondary-600 dark:text-gray-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Kiểm tra thư mục spam/junk
                    </div>
                    <div class="flex items-center justify-center text-secondary-600 dark:text-gray-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Chờ vài phút rồi kiểm tra lại
                    </div>
                    <div class="flex items-center justify-center text-secondary-600 dark:text-gray-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Đảm bảo email chính xác
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center">
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-sm text-secondary-600 dark:text-gray-300 hover:text-secondary-700 dark:hover:text-gray-200 font-medium transition-colors duration-200">
                    Đăng xuất
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
