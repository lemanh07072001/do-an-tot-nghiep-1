<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkAuthIsAmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();

        // Kiểm tra nếu user đã đăng nhập và có ít nhất 1 role
        if ($user && $user->roles->isNotEmpty()) {
            return $next($request); // Cho phép truy cập nếu có role
        }

        // Chuyển hướng về trang khác với thông báo lỗi
        return redirect()->route('index')->with('error', 'Bạn chưa được phân quyền truy cập.');

    }
}
