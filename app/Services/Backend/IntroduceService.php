<?php


namespace App\Services\Backend;

use App\Models\Introduce;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Banner;
use App\Helpers\FormatFunction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class IntroduceService
{
    public function uploadImage($request)
    {
        if ($request->hasFile('file')) {
            $pathFull = 'upload';
            $file = $request->file('file');
            $name = $file->getClientOriginalName();
            $path = $file->storeAs($pathFull, $name);

            return response()->json(['location' => Storage::url($path)]);
        }

        return response()->json(['error' => 'Upload failed'], 400);
    }

    public function store($request)
    {
        try{
            $about = Introduce::first() ?? new Introduce();

            $about->content = $request->content;
            $dataInsert = $about->save();
            if ($dataInsert) {
                // Thông báo thành công
                flash()->success('Cập nhật thành công!');

                // Chuyển hướng trang
                return redirect()->route('setting_module.introduce.index');
            } else {
                // Thông báo thành công
                flash()->error('Lỗi hệ thống vui lòng thử lại sau!');

                // Chuyển hướng trang
                return redirect()->back();
            }
        } catch (\Exception $e) {
            // Thông báo lỗi xử lý
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getData()
    {
        return Introduce::first();
    }
}
