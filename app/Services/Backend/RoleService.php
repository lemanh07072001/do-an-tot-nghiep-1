<?php


namespace App\Services\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Banner;
use App\Helpers\FormatFunction;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleService
{
    public function getData($request)
    {
        $searchInput = $request->searchInput;

        $filer = [];

        $query =  Role::query();

        if ($request->has('searchInput') && isset($searchInput)) {
            $query->where(function ($query) use ($searchInput) {
                $query->where('name', 'like', '%' . $searchInput . '%');
            });
        }


        return DataTables::of($query)
            ->addColumn('role', function ($role) {

                return $role->name;
            })
            ->addColumn('permission', function ($role) {
                $html = '';
                $html .= '<span class="flex flex-wrap ">';
                foreach ($role->permissions->pluck('name') as $item) {

                    $html .= '<span class="mb-1 bg-purple-100 text-purple-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded ">' . $item . '</span>';
                }
                $html .= '</span>';
                return $html;
            })

            ->addColumn('action', function ($role) {
                $actions = '';

                // Kiểm tra quyền cập nhật phân quyền
                if (auth()->user()->can('Cập nhật phân quyền')) {
                    $actions .= '<a href="' . route('account_module.role.edit', ['role' => $role]) . '"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-400 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-400 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                    </svg>
                </a>';
                }

                // Kiểm tra quyền xóa phân quyền
                if (auth()->user()->can('Xoá phân quyền')) {
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

            ->rawColumns(['permission', 'action'])
            ->make(true);
    }

    public function getPermission($request){
        return Permission::all();
    }

    public function store($request){


        try{
            $request->validate([
                'name' => 'required|unique:permissions,name',
            ]);

            $dataInsert = Role::create([
                'name' => $request->input('name'),
            ]);

            if ($dataInsert) {
                $dataInsert->syncPermissions($request->permission);
                // NOTE - Thông báo
                flash()->success('Thêm mới vai trò thành công!');
                // Chuyển hướng trang
                return redirect()->route('account_module.role.index');
            } else {
                // Thông báo thất bại
                flash()->error('Thêm mói thất bại! Vui lòng đợi trong ít phút');
                // Chuyển hướng trang
                return redirect()->back();
            }
        } catch (\Exception $e) {
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
            $roles = Role::whereIn('id', $request->id)->get();
            $rolesInUse = [];

            foreach ($roles as $role) {
                if ($role->users()->exists()) {
                    $rolesInUse[] = $role->name; // Thêm tên role vào mảng
                }
            }
            if (!empty($rolesInUse)) {
                return response()->json([
                    'message' => 'Các role sau đang được sử dụng: '. implode(' , ', $rolesInUse),
                    'roles_in_use' => $rolesInUse // Trả về danh sách tên role
                ], 500);
            }else{
                Role::destroy($request->id);
                return response()->json([
                    'message' => 'Bạn đã xoá thành công ' . implode(' , ', $rolesInUse),
                ], 200);
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
            // Tìm role theo tên
            $role = Role::where('id', $request->id)->first();

            if (!$role) {
                return response()->json([
                    'message' => 'Role không tồn tại.'
                ], 500);

            }

            // Kiểm tra xem role này có được gán cho bất kỳ user nào không
            if ($role->users()->exists()) {
                return response()->json([
                    'message' => 'Role này đang được sử dụng bởi một hoặc nhiều người dùng.'
                ], 500);

            } else {
                $role->delete();

                return response()->json([
                    'message' => 'Bạn đã xoá thành công'
                ], 200);
            }


        } catch (\Exception $e) {
            // Thông báo lỗi xử lý
            return response()->json([
                'message' => 'Lỗi hệ thống vui lòng thử lại sau!'
            ], 500);
        }
    }
}
