<?php


namespace App\Services\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Banner;
use App\Helpers\FormatFunction;
use App\Models\Policy;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PolicyService
{
    public function getData($request)
    {
        $searchInput = $request->searchInput;


        $filer = [];

        $query =  Policy::query();


        if ($request->has('searchInput') && isset($searchInput)) {
            $query->where(function ($query) use ($searchInput) {
                $query->where('name', 'like', '%' . $searchInput . '%');
            });
        }



        if (!empty($filer)) {
            $query = $query->where($filer);
        }


        return DataTables::of($query)
            ->addColumn('name', function ($policy) {
                return $policy->name;
            })

            ->addColumn('action', function ($policy) {
                return '
                        <a href="' . route('setting_module.policy.edit', ['policy' => $policy]) . '" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-400 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-400 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            <svg class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                        </a>

                        <button type="button" data-delete="deleteRow" class="deleteRow inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                            <svg class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        </button>
                    ';
            })

            ->rawColumns(['name', 'action'])
            ->make(true);
    }


    public function store($request)
    {
        try{
            $data = [
                'name' => $request->name,
                'content' => $request->content,
                'created_at' => FormatFunction::getDatetime(),
            ];

            $dataInsert = Policy::create($data);

            if ($dataInsert) {
                // NOTE - Thông báo
                flash()->success('Thêm mới chính sách thành công!');
                // Chuyển hướng trang
                return redirect()->route('setting_module.policy.index');
            } else {
                // Thông báo thất bại
                flash()->error('Thêm mói thất bại! Vui lòng đợi trong ít phút');
                // Chuyển hướng trang
                return redirect()->back();
            }
        }catch (\Exception $e) {
            // Thông báo lỗi xử lý
            flash()->error($e->getMessage());
            return redirect()->back();
        }
    }

    public function update($request, $policy)
    {
        try{
            $data = [
                'name' => $request->name,
                'content' => $request->content,
                'created_at' => FormatFunction::getDatetime(),
            ];

            $dataUpdate = $policy->update($data);

            if ($dataUpdate) {
                // NOTE - Thông báo
                flash()->success('Cập nhật mới chính sách thành công!');
                // Chuyển hướng trang
                return redirect()->route('setting_module.policy.index');
            } else {
                // Thông báo thất bại
                flash()->error('Cập nhật thất bại! Vui lòng đợi trong ít phút');
                // Chuyển hướng trang
                return redirect()->back();
            }
        }catch (\Exception $e) {
            // Thông báo lỗi xử lý
            flash()->error($e->getMessage());
            return redirect()->back();
        }
    }




    //NOTE - Xóa tất cả dữ liệu được chọn
    public function deleteAll($request)
    {
        // Xử lý ngoại lệ
        try {
            // Lấy id
            $ids = $request->id;

            // Xóa tài khoản
            $dataDelete = Policy::destroy($ids);
            if ($dataDelete) {
                // Thông báo thành công
                return response()->json([
                    'message' => 'Xóa chính sách thành công!'
                ], 200);
            } else {
                // Thông báo thất bại
                return response()->json([
                    'message' => 'Lỗi hệ thống vui lòng thử lại sau!'
                ], 500);
            }
        } catch (\Exception $e) {
            // Thông báo lỗi xử lý
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    //NOTE - Xóa tài khoản đang chọn
    public function deleteRow($request)
    {
        // Xử lý ngoại lệ
        try {
            // Lấy id
            $id = $request->id;
            // Xóa tài khoản
            $dataDelete = Policy::find($id)->delete();
            if ($dataDelete) {
                // Thông báo thành công
                return response()->json([
                    'message' => 'Xóa chính sách thành công!'
                ], 200);
            } else {
                // Thông báo thất bại
                return response()->json([
                    'message' => 'Lỗi hệ thống vui lòng thử lại sau!'
                ], 500);
            }
        } catch (\Exception $e) {
            // Thông báo lỗi xử lý
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

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

    public function processContent($request)
    {
        $content = $request->input('content');

        // Gọi API AI hoặc xử lý nội dung bằng mô hình AI
        $newContent = $this->callAIAssistant($content);

        return response()->json(['newContent' => $newContent]);
    }

    private function callAIAssistant($content)
    {
        // Ví dụ: Gọi OpenAI API hoặc sử dụng mô hình AI của riêng bạn

        // Sử dụng Guzzle để gọi API
        $question = $content ?? 'Hello';
        $result   = Gemini::geminiPro()->generateContent($question);
        return $result->text();
    }

}
