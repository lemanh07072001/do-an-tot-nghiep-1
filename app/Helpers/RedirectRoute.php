<?php


namespace App\Helpers;


class RedirectRoute
{
    public static function redirect($route, $message = "")
    {
        if (request()->input('action') == 'save') {
            emotify('success', $message);
            return redirect()->route($route . '.create');
        } else if (request()->input('action') == 'save_exit') {
            emotify('success', $message);
            return redirect()->route($route . '.index');
        }
    }

    public static function redirectError(
        $error = 'Lỗi! Không thể thêm tài khoản bây giờ. Vui lòng thử lại sau ít phút!'
    ) {
        emotify('error', $error);
        return redirect()->back();
    }
}
