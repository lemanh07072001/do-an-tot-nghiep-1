<?php


namespace App\Services\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\Status;
use App\Models\Banner;
use App\Models\Client;
use App\Helpers\FormatFunction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ClientService
{
    public function getData($request)
    {
        $searchInput = $request->searchInput;
        $searchStatus = $request->searchStatus;

        $filer = [];

        $query =  Client::query();

        $query =  $query->with('profiles');

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

            ->addColumn('avatar', function ($client) {
                return FormatFunction::formatAvatar($client);
            })
            ->addColumn('name', function ($client) {
                return $client->name;
            })
            ->addColumn('email', function ($client) {
                return $client->email;
            })
            ->addColumn('status', function ($client) {
                return FormatFunction::formatBadge($client->status);
            })
            ->addColumn('action', function ($client) {
                return '
                        <a href="' . route('account_module.client.edit', ['client' => $client]) . '" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-400 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-400 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            <svg class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                        </a>

                        <button type="button" data-delete="deleteRow" class="deleteRow inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                            <svg class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        </button>
                    ';
            })

            ->rawColumns(['avatar', 'name', 'status', 'email_verified_at', 'action'])
            ->make(true);
    }

    public function store($request)
    {
        // Xử lý ngoại lệ

        try {
            //NOTE - Lưu thông tin người dùng vào cơ sở dữ liệu
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => Status::Active,
                'created_at' => FormatFunction::getDatetime(),
            ];

            //NOTE - Lưu vào cơ sở dữ liệu
            $dataInsert = Client::create($data);

            //NOTE - Thông báo
            if ($dataInsert) {
                $profilesData = [
                    'phone' => $request->phone,
                    'address' => $request->address,
                ];
                $dataInsert->profiles()->create($profilesData);
                // Thông báo thành công
                flash()->success('Tạo tài khoản thành công!');
                // Chuyển hướng trang
                return redirect()->route('account_module.client.index');
            } else {
                // Thông báo thất bại
                flash()->error('Tạo tài khoản thất bại! Vui lòng đợi trong ít phút');
                // Chuyển hướng trang
                return redirect()->back();
            }
        } catch (\Exception $e) {
            // Thông báo lỗi xử lý
            flash()->error($e->getMessage());
        }
    }

    public function update($request, $client)
    {
        // Xử lý ngoại lệ
        try {
            //NOTE - Lưu thông tin người dùng vào cơ sở dữ liệu
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => Status::Active,
                'created_at' => FormatFunction::getDatetime(),
            ];

            //NOTE - Lưu vào cơ sở dữ liệu
            $dataUpdate = $client->update($data);

            //NOTE - Thông báo
            if ($dataUpdate) {
                $profilesData = [
                    'phone' => $request->phone,
                    'address' => $request->address,
                ];
                $client->profiles()->update($profilesData);
                // Thông báo thành công
                flash()->success('Cập nhật tài khoản thành công!');
                // Chuyển hướng trang
                return redirect()->route('account_module.client.index');
            } else {
                // Thông báo thất bại
                flash()->error('Cập nhật tài khoản thất bại! Vui lòng đợi trong ít phút');
                // Chuyển hướng trang
                return redirect()->back();
            }
        } catch (\Exception $e) {
            // Thông báo lỗi xử lý
            flash()->error($e->getMessage());
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
            $changeStatus = Client::find($id)->update(['status' => !$request->value]);

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

            // Xóa tài khoản
            $dataDelete = Client::destroy($ids);
            if ($dataDelete) {
                // Thông báo thành công
                return response()->json([
                    'message' => 'Xóa người dùng sản phẩm thành công!'
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
                'message' => $e->getMessage(),
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
            $dataDelete = Client::find($id)->delete();
            if ($dataDelete) {
                // Thông báo thành công
                return response()->json([
                    'message' => 'Xóa người dùng sản phẩm thành công!'
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
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function getAllUsersSelect()
    {
        return User::select(['id', 'name'])->get();
    }
}
