<?php


namespace App\Services\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Brand;

use App\Models\Banner;
use App\Models\Voucher;
use App\Models\Properties;
use App\Helpers\FormatFunction;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class VoucherService
{
    public function getData($request)
    {
        $searchInput = $request->searchInput;
        $searchStatus = $request->searchStatus;
        $searchUser = $request->searchUser;

        $filer = [];

        $query =  Voucher::query();

        $query = $query->with(['user']);

        if ($request->has('searchInput') && isset($searchInput)) {
            $query->where(function ($query) use ($searchInput) {
                $query->where('name', 'like', '%' . $searchInput . '%');
            });
        }

        if ($request->has('searchStatus') && isset($searchStatus)) {

            $filer[] = ['status', '=', $searchStatus];
        }

        if ($request->has('searchUser') && isset($searchUser)) {

            $filer[] = ['user_id', '=', $searchUser];
        }


        if (!empty($filer)) {
            $query = $query->where($filer);
        }


        return DataTables::of($query)
            ->addColumn('name', function ($voucher) {
                return '<div class="text-green-700">' . $voucher->name . '</div>';
            })
            ->addColumn('sale', function ($voucher) {
                return FormatFunction::formatSaleVoucher($voucher);
            })
            ->addColumn('quantity', function ($voucher) {
                return FormatFunction::formatQuantityVoucher($voucher);
            })
            ->addColumn('user_id', function ($voucher) {
                return $voucher->user->name;
            })
            ->addColumn('status', function ($voucher) {
                return FormatFunction::formatBadge($voucher->status);
            })
            ->addColumn('time', function ($voucher) {
                return FormatFunction::formatDateSafe($voucher);
            })
            ->addColumn('action', function ($voucher) {
                $actions = '';

                // Kiểm tra quyền cập nhật khuyến mãi
                if (auth()->user()->can('Cập nhật khuyến mãi')) {
                    $actions .= '<a href="' . route('ecommerce_module.voucher.edit', ['voucher' => $voucher]) . '"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-400 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-400 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                    </svg>
                </a>';
                }

                // Kiểm tra quyền xóa khuyến mãi
                if (auth()->user()->can('Xoá khuyến mãi')) {
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

            ->rawColumns(['name', 'sale', 'status', 'action', 'quantity', 'time'])
            ->make(true);
    }


    public function store($request)
    {

        try {
            $dateStart = null;
            $dateEnd = null;

            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateStart = Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d');

                $dateEnd = Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d');
            }


            //NOTE - Lưu thông tin người dùng vào cơ sở dữ liệu
            $data = [
                'name' => $request->name,
                'discount_type' => $request->discount_type,
                'value_reduction' => (int) str_replace('.', '', $request->value_reduction),
                'status' => $request->status,
                'date_start' => $dateStart,
                'date_end' => $dateEnd,
                'limit' => $request->limit,
                'user_id' => Auth::id(),
                'created_at' => FormatFunction::getDatetime(),
            ];

            //NOTE - Lưu vào cơ sở dữ liệu
            $dataInsert = Voucher::create($data);



            //NOTE - Thông báo
            if ($dataInsert) {
                // Chuyển hướng trang
                return redirect()->route('ecommerce_module.voucher.index');
                // Thông báo thành công
                flash()->success('Tạo voucher thành công!');
            } else {
                // Thông báo thất bại
                flash()->error('Tạo voucher thất bại! Vui lòng đợi trong ít phút');
                // Chuyển hướng trang
                return redirect()->back();
            }
        } catch (\Exception $e) {
            flash()->error($e->getMessage());
        }
    }


    public function update($request, $voucher)
    {
        try {
            $dateStart = null;
            $dateEnd = null;

            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateStart = Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d');

                $dateEnd = Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d');
            }


            //NOTE - Lưu thông tin người dùng vào cơ sở dữ liệu
            $data = [
                'name' => $request->name,
                'discount_type' => $request->discount_type,
                'value_reduction' => FormatFunction::formatPrice($request->value_reduction),
                'status' => $request->status,
                'date_start' => $dateStart,
                'date_end' => $dateEnd,
                'limit' => $request->limit,
                'user_id' => Auth::id(),
                'updated_at' => FormatFunction::getDatetime(),
            ];



            //NOTE - Lưu vào cơ sở dữ liệu
            $dataInsert = $voucher->update($data);


            //NOTE - Thông báo
            if ($dataInsert) {
                flash()->success('Cập nhật voucher thành công!');
                // Chuyển hướng trang
                return redirect()->route('ecommerce_module.voucher.index');
            } else {
                // Thông báo thất bại
                flash()->error('Tạo voucher thất bại! Vui lòng đợi trong ít phút');
                // Chuyển hướng trang
                return redirect()->back();
            }
        } catch (\Exception $e) {
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
            $changeStatus = Voucher::find($id)->update(['status' => !$request->value]);

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
                'message' => $e->getMessage(),
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
            $dataDelete = Voucher::destroy($ids);
            if ($dataDelete) {
                // Thông báo thành công
                return response()->json([
                    'message' => 'Xóa nhãn sản phẩm thành công!'
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
            $dataDelete = Voucher::find($id)->delete();
            if ($dataDelete) {
                // Thông báo thành công
                return response()->json([
                    'message' => 'Xóa nhãn sản phẩm thành công!'
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
