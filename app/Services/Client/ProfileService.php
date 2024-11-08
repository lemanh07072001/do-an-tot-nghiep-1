<?php

namespace App\Services\Client;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileService
{
    public function showTabs($request){
        if (!$request->has('view')) {
            return redirect()->route('showTabs', ['view' => 'danh-sach-don-hang']);
        }

        $activeTab = $request->query('view', 'danh-sach-don-hang');

        return $activeTab;
    }

    public function getOders($request){
        $getOrder = Order::where('user_id', Auth::id())
                            ->simplePaginate(5)
                            ->withQueryString();
        return $getOrder;
    }

    public function getProfile(){
        return Auth::user();
    }

    public function changePassword($request){
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu không khớp với mật khẩu mới.',
        ]);

        // Kiểm tra mật khẩu hiện tại có đúng không
        if (!Hash::check($request->current_password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Mật khẩu hiện tại không đúng.',
            ]);
        }


        // Cập nhật mật khẩu mới cho người dùng
        $changePassword = $request->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        if ($changePassword) {
            return redirect()->route('showTabs', ['view' => 'doi-mat-khau'])
            ->with('success', 'Mật khẩu đã được cập nhật thành công!');
        }

        // Thông báo lỗi nếu cập nhật thất bại
        return redirect()->back()->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại.');
    }
}
