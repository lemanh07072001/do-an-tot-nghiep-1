<?php


namespace App\Services\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Banner;
use App\Models\Products;
use App\Helpers\FormatFunction;
use App\Models\GroupProduct;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class GroupProductService
{
    public function getData($request)
    {
        $searchInput = $request->searchInput;
        $searchStatus = $request->searchStatus;

        $filer = [];

        $query =  GroupProduct::query();



        if ($request->has('searchInput') && isset($searchInput)) {
            $query->where(function ($query) use ($searchInput) {
                $query->where('name', 'like', '%' . $searchInput . '%');
            });
        }

        if ($request->has('searchStatus') && isset($searchStatus)) {

            $filer[] = ['status', '=', $searchStatus];
        }

        if (!empty($filer)) {
            $query = $query->where($filer);
        }


        return DataTables::of($query)
            ->addColumn('name', function ($groupProduct) {
                return $groupProduct->name;
            })
            ->addColumn('status', function ($groupProduct) {
                return FormatFunction::formatBadge($groupProduct->status);
            })
            ->addColumn('action', function ($groupProduct) {
                return '
                        <a href="' . route('ecommerce_module.groupProduct.edit', ['groupProduct' => $groupProduct]) . '" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-400 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-400 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            <svg class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                        </a>

                        <button type="button" data-delete="deleteRow" class="deleteRow inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                            <svg class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        </button>
                    ';
            })

            ->rawColumns(['name', 'status', 'link', 'action'])
            ->make(true);
    }


    public function store($request)
    {
        try {
            $productIds = $request->idArray;

            $data = [
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status,
                'created_at' => FormatFunction::getDatetime(),
            ];


            $dataInsert = GroupProduct::create($data);
            //NOTE - Thông báo
            if ($dataInsert) {
                $dataInsert->products()->sync($productIds);
                // Thông báo thành công
                flash()->success('Thêm nhóm sản phẩm thành công!');

                // Chuyển hướng trang
                return redirect()->route('ecommerce_module.groupProduct.index');
            } else {
                // Thông báo thất bại
                flash()->error('Tạo tài khoản thất bại! Vui lòng đợi trong ít phút');
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

    public function update($request, $groupProduct)
    {
        try {
            $productIds = $request->idArray;

            $data = [
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status,
                'updated_at' => FormatFunction::getDatetime(),
            ];


            $dataUpdate = $groupProduct->update($data);
            //NOTE - Thông báo
            if ($dataUpdate) {
                $groupProduct->products()->sync($productIds);
                // Thông báo thành công
                flash()->success('Cập nhật nhóm sản phẩm thành công!');

                // Chuyển hướng trang
                return redirect()->route('ecommerce_module.groupProduct.index');
            } else {
                // Thông báo thất bại
                flash()->error('Cập nhật nhóm sản phẩm thất bại! Vui lòng đợi trong ít phút');
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


    //NOTE - Cập nhật toggle status
    public function toggleStatus($request)
    {
        // Xử lý ngoại lệ
        try {
            // Lấy ID
            $id = $request->id;

            // Xử lý cập nhật status
            $changeStatus = GroupProduct::find($id)->update(['status' => !$request->value]);

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
            $dataDelete = GroupProduct::destroy($ids);
            if ($dataDelete) {
                // Thông báo thành công
                return response()->json([
                    'message' => 'Xóa banner thành công!'
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
            $dataDelete = GroupProduct::find($id)->delete();
            if ($dataDelete) {
                // Thông báo thành công
                return response()->json([
                    'message' => 'Xóa banner thành công!'
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

    public function getAllUsersSelect()
    {
        return User::select(['id', 'name'])->get();
    }

    public function getAllProducts()
    {
        return Products::select(['id', 'name', 'avatar'])->get();
    }

    public function searchProduct($request)
    {
        $search = $request->get('search');

        return Products::select(['id', 'name', 'avatar'])->where('name', 'like', '%' . $search . '%')->get();
    }

    public function getGroupProduct($groupProduct)
    {
        return $groupProduct->products->select('id', 'name', 'avatar')->toArray();
    }
}
