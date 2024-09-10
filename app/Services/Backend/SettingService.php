<?php


namespace App\Services\Backend;

use App\Models\Setting;


class SettingService
{
    public function getAllSettings(){
        $settings = Setting::all()->pluck('setting_value','setting_key')->toArray();
        return $settings;
    }

    public function updateOrCreate($request){


        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['setting_key' => $key], ['setting_value' => $value]);
        }



        flash()->success('Cập nhật thành công!');
        // Chuyển hướng trang
        return redirect()->back();
    }


}
