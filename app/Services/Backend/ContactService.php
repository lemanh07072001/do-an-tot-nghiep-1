<?php


namespace App\Services\Backend;

use App\Events\ContentMessage;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Banner;
use App\Models\Contact;
use App\Helpers\FormatFunction;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ContactService
{
    public function getData($request)
    {
        $searchInput = $request->searchInput;

        $query =  Contact::query();

        if ($request->has('searchInput') && isset($searchInput)) {
            $query->where(function ($query) use ($searchInput) {
                $query->where('name', 'like', '%' . $searchInput . '%')
                      ->orWhere('email', 'like', '%' . $searchInput . '%')
                      ->orWhere('phone', 'like', '%' . $searchInput . '%');
            });
        }

        return DataTables::of($query)
            ->addColumn('info', function ($contact) {
                return FormatFunction::formatTitleContact($contact);
            })
            ->addColumn('message', function ($contact) {
                return FormatFunction::formatTitleMessage($contact);
            })
            ->addColumn('status', function ($contact) {
                return FormatFunction::formatStatusCContent($contact);
            })
            ->addColumn('action', function ($contact) {
                return '

                        <button type="button" data-delete="deleteRow" class="deleteRow inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                            <svg class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        </button>
                    ';
            })

            ->rawColumns(['info', 'message',  'status', 'action'])
            ->make(true);
    }


    public function getMessage($request)
    {
        $id = $request->get('id');

        $getFind = Contact::findOrFail($id);

        $getFind->update(['status' => '2']);
        return response()->json($getFind);
    }



    public function sendMessage($request){
        $value = $request->get('value');
        $id = $request->get('id');

        $getFind =  Contact::findOrFail($id);
        $data = [
            'repMessage' => $value,
            'status' => '1'
        ];

        $getFind->update($data);

        event(new ContentMessage($getFind));

        return response()->json([
            'message' => 'Cập nhật thành công!'
        ], 200);
    }

    //NOTE - Xóa tất cả dữ liệu được chọn
    public function deleteAll($request)
    {
        // Xử lý ngoại lệ
        try {
            // Lấy id
            $ids = $request->id;

            // Xóa tài khoản
            $dataDelete = Contact::destroy($ids);
            if ($dataDelete) {
                // Thông báo thành công
                return response()->json([
                    'message' => 'Xóa thành công!'
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
                'message' => 'Lỗi hệ thống vui lòng thử lại sau!'
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
            $dataDelete = Contact::find($id)->delete();
            if ($dataDelete) {
                // Thông báo thành công
                return response()->json([
                    'message' => 'Xóa thành công!'
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
                'message' => 'Lỗi hệ thống vui lòng thử lại sau!'
            ], 500);
        }
    }


}
