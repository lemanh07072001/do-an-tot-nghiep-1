<?php


namespace App\Services\Backend;


use Carbon\Carbon;
use App\Models\User;
use App\Enums\Status;
use Laravolt\Avatar\Avatar;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Helpers\FormatFunction;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NotifyUserOfCompletedImport;

class UserService
{
    public function getDatatable($request)
    {
        $searchInput = $request->searchInput;
        $searchStatus = $request->searchStatus;

        $filer = [];

        $query =  User::query();

        if ($request->has('searchInput') && isset($searchInput)) {
            $query->where(function ($query) use ($searchInput) {
                $query->where('email', 'like', '%' . $searchInput . '%')
                    ->orWhere('name', 'like', '%' . $searchInput . '%');
            });
        }

        if ($request->has('searchStatus') && isset($searchStatus)) {

            $query->where('status', '=', $searchStatus);
        }

        if (!empty($filer)) {
            $query->where($filer);
        }


        return DataTables::eloquent($query)

            ->addColumn('avatar', function ($user) {
                return FormatFunction::formatAvatar($user);
            })
            ->addColumn('name', function ($user) {
                return $user->name;
            })
            ->addColumn('email', function ($user) {
                return $user->email;
            })
            ->addColumn('email_verified_at', function ($user) {
                return FormatFunction::formatVeryEmail($user->email_verified_at);
            })
            ->addColumn('datetime', function ($user) {
                return FormatFunction::formatDate($user->created_at);
            })
            ->addColumn('status', function ($user) {
                return FormatFunction::formatBadge($user->status);
            })
            ->addColumn('action', function ($user) {
                $actions = '';

                // Kiểm tra quyền cập nhật tài khoản
                if (auth()->user()->can('Cập nhật tài khoản')) {
                    $actions .= '<a href="' . route('account_module.user.edit', ['user' => $user]) . '"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-400 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-400 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                    </svg>
                </a>';
                }

                // Kiểm tra quyền xóa tài khoản
                if (auth()->user()->can('Xoá tài khoản')) {
                    $actions .= '<button type="button" data-delete="deleteRow"
                    class="deleteRow ml-2 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>';
                }

                // Nếu không có quyền nào thì trả về một thông báo hoặc HTML trống
                return $actions ?: '<span class="text-gray-500">Không có quyền</span>';
            })

            ->rawColumns(['avatar', 'name', 'status', 'email_verified_at', 'action'])
            ->make(true);
    }

    public function store($request)
    {
        // Xử lý ngoại lệ
        try {

            if ($request->status == 'on') {
                $status = 0;
            } else {
                $status = 1;
            }

            //NOTE - Lưu thông tin người dùng vào cơ sở dữ liệu
            $data = [
                'name' => $request->name,
                'email' => $request->email,

                'password' => Hash::make($request->password),
                'status' => $status,
            ];

            //NOTE - Lưu vào cơ sở dữ liệu
            $dataInsert = User::create($data);

            //NOTE - Thông báo
            if ($dataInsert) {
                if($request->role != null){
                    $managerRole = Role::where('id', $request->role)->first();

                    if ($managerRole) {
                        $dataInsert->assignRole($managerRole);
                    }
                }
                // Thông báo thành công
                flash()->success('Tạo tài khoản thành công!');
                // Chuyển hướng trang
                return redirect()->route('account_module.user.index');
            } else {
                // Thông báo thất bại
                flash()->error('Tạo tài khoản thất bại! Vui lòng đợi trong ít phút');
                // Chuyển hướng trang
                return redirect()->back();
            }
        } catch (\Exception $e) {
            // Thông báo lỗi xử lý
            return response()->json([
                'message' => 'Lỗi hệ thống vui lòng thử lại sau!'
            ], 500);
        }
    }

    public function update($request, $user)
    {

        // Xử lý ngoại lệ
        try {

            if ($request->status == 'on') {
                $status = 0;
            } else {
                $status = 1;
            }
            //NOTE - Lưu thông tin người dùng vào cơ sở dữ liệu
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'status' => $status,
            ];

            if($request->password !== null){
                $data['password']  =  Hash::make($request->password);
            }

            //NOTE - Lưu vào cơ sở dữ liệu
            $dataUpdate = $user->update($data);

            //NOTE - Thông báo
            if ($dataUpdate) {
                if ($request->role != null) {
                    $managerRole = Role::where('id', $request->role)->first();

                    if ($managerRole) {
                        $user->syncRoles($managerRole);
                    }
                }

                // Thông báo thành công
                flash()->success('Cập nhật khoản thành công!');

                // Chuyển hướng trang
                return redirect()->route('account_module.user.index');
            } else {
                // Thông báo thất bại
                flash()->error('Cập nhật thất bại! Vui lòng đợi trong ít phút');

                // Chuyển hướng trang
                return redirect()->back();
            }
        } catch (\Exception $e) {
            // Thông báo lỗi xử lý
            return response()->json([
                'message' => 'Lỗi hệ thống vui lòng thử lại sau!'
            ], 500);
        }
    }

    //NOTE - Cập nhật toggle status
    public function toggleStatus($request)
    {
        // Xử lý ngoại lệ
        try {
            // Lấy ID
            $id = $request->id;

            // Xử lý cập nhật status
            $changeStatus = User::find($id)->update(['status' => !$request->value]);

            // Thông báo
            if ($changeStatus) {
                // Thành công
                return response()->json([
                    'message' => 'Cập nhật trạng thái thành công!'
                ], 200);
            } else {
                // Thất bại
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

    //NOTE - Xóa tất cả dữ liệu được chọn
    public function deleteAll($request)
    {
        // Xử lý ngoại lệ
        try {
            // Lấy id
            $ids = $request->id;

            // Kiểm tra xem người dùng đang đăng nhập có phải người xóa
            if (in_array(Auth::id(), $ids)) {
                $getEmail = Auth::user();
                return response()->json([
                    'message' => 'Bạn không thể xóa tài khoản ' . $getEmail->email . '!'
                ], 500);
            } else {
                // Xóa tài khoản
                $dataDelete = User::destroy($ids);
                if ($dataDelete) {
                    // Thông báo thành công
                    return response()->json([
                        'message' => 'Xóa tài khoản thành công!'
                    ], 200);
                } else {
                    // Thông báo thất bại
                    return response()->json([
                        'message' => 'Lỗi hệ thống vui lòng thử lại sau!'
                    ], 500);
                }
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
            // Kiểm tra xem người dùng đang đăng nhập có phải người xóa
            if (Auth::id() == $id) {
                $getEmail = Auth::user();
                return response()->json([
                    'message' => 'Bạn không thể xóa tài khoản ' . $getEmail->email . '!'
                ], 500);
            } else {
                // Xóa tài khoản
                $dataDelete = User::find($id)->delete();
                if ($dataDelete) {
                    // Thông báo thành công
                    return response()->json([
                        'message' => 'Xóa tài khoản thành công!'
                    ], 200);
                } else {
                    // Thông báo thất bại
                    return response()->json([
                        'message' => 'Lỗi hệ thống vui lòng thử lại sau!'
                    ], 500);
                }
            }
        } catch (\Exception $e) {
            // Thông báo lỗi xử lý
            return response()->json([
                'message' => 'Lỗi hệ thống vui lòng thử lại sau!'
            ], 500);
        }
    }

    /**
     * This function exports selected user data to an Excel file.
     *
     * @param Illuminate\Http\Request $request The request object containing the selected user IDs.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response with the URL of the exported Excel file.
     *
     * @throws \Exception If an error occurs during the export process.
     */
    public function exportExcel($request)
    {
        // Get the current year, date, and month
        $year = Carbon::now()->year;
        $date = Carbon::now()->day;
        $month = Carbon::now()->month;

        // Construct the file name for the exported Excel file
        $fileName = 'export/account/' . $year . '/' . $date . '-' . $month . '-' . time() . '.xlsx';

        // Use the Excel facade to store the exported data in the specified file path
        Excel::store(new UsersExport($request->id), $fileName, 'public');

        // Return a JSON response with the URL of the exported Excel file
        return response()->json([
            'file' => Storage::url($fileName)
        ]);
    }

    /**
     * Imports user data from an Excel file.
     *
     * This function processes the uploaded Excel file, retrieves the user data, and inserts it into the database.
     *
     * @param Illuminate\Http\Request $request The request object containing the uploaded Excel file.
     *
     * @return void
     *
     * @throws \Exception If an error occurs during the import process.
     */
    public function importExcel($request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        try {
            Excel::queueImport(new UsersImport, $request->file('file'));

            return response()->json(['message' => 'Dữ liệu đang được import vui lòng quay lại sau ít phút!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error importing users: ' . $e->getMessage()], 500);
        }
    }

    public function GetRole()
    {
        return Role::all();
    }
}
