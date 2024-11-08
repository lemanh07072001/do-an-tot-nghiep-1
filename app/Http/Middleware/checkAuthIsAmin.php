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
        // if (Auth::check()) {
        //     if (Auth::user()->is_admin) {
        //         // Nếu người dùng đã là admin và đang không truy cập trang admin
        //         if (!$request->is('admin/*')) {
        //             return redirect()->route('dashboard_module.dashboard.index'); // Chuyển hướng đến trang admin dashboard
        //         }
        //     } else {
        //         // Nếu người dùng không phải là admin và đang cố truy cập trang admin
        //         if ($request->is('admin/*')) {
        //             return redirect('/'); // Chuyển hướng đến trang người dùng
        //         }
        //     }
        // } else {
        //     return redirect('/login')->with('error', 'Please login first'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        // }

        $user = Auth::user();

        if(!$user->is_admin){
            return redirect("/");
        }
        return $next($request); // Cho phép tiếp tục thực hiện request nếu không có vấn đề
    }
}
