<?php


namespace App\Services\Backend;

use App\Models\User;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Properties;
use App\Helpers\FormatFunction;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CategoriesService
{
    public function getData($request)
    {
        $searchInput = $request->searchInput;
        $searchStatus = $request->searchStatus;
        $searchUser = $request->searchUser;

        $filer = [];

        $query =  Categories::query();

        $query = $query->with(['user', 'products'])
            ->withDepth()
            ->defaultOrder();

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

        $query =  $query->get()->toFlatTree();


        return DataTables::of($query)
            ->addColumn('name', function ($categories) {
                return FormatFunction::formatTitleCategories($categories);
            })
            ->addColumn('detaiProductCategories', function ($categories) {
                return '<button data-id="' . $categories->id . '" type="button" class="detaiProductCategories px-3 py-2 rounded-lg text-xs font-medium text-center text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 ">Chi tiết</button>';
            })
            ->addColumn('count_product', function ($categories) {
                return FormatFunction::formatCountProductCategories($categories);
            })
            ->addColumn('categories_id', function ($categories) {
                return $categories->user->name;
            })
            ->addColumn('datetime', function ($categories) {
                return FormatFunction::formatDate($categories->created_at);
            })
            ->addColumn('status', function ($categories) {
                return FormatFunction::formatBadge($categories->status);
            })
            ->addColumn('action', function ($categories) {
                $actions = '';

                // Kiểm tra quyền cập nhật danh mục
                if (auth()->user()->can('Cập nhật danh mục')) {
                    $actions .= '<a href="' . route('ecommerce_module.categories.edit', ['categories' => $categories]) . '"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-400 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-400 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                    </svg>
                </a>';
                }

                // Kiểm tra quyền xóa danh mục
                if (auth()->user()->can('Xoá danh mục')) {
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

            ->rawColumns(['name', 'categories_id', 'count_product', 'status', 'detaiProductCategories', 'datetime', 'action'])
            ->make(true);
    }

    public function store($request)
    {
        // Xử lý ngoại lệ
        try {

            if ($request->hot == 'on') {
                $hot = 0;
            } else {
                $hot = 1;
            }

            //NOTE - Lưu thông tin người dùng vào cơ sở dữ liệu
            $data = [
                'name' => $request->name,
                'slug' => $request->slug,
                'parent_id' => $request->parent_id,
                'status' => $request->status,
                'description' => $request->description,
                'hot' => $hot,
                'image' => $request->image,
                'user_id' => Auth::id(),
            ];

            //NOTE - Lưu vào cơ sở dữ liệu
            $dataInsert = Categories::create($data);
            //NOTE - Thông báo
            if ($dataInsert) {


                // Chuyển hướng trang
                return redirect()->route('ecommerce_module.categories.index');
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

    public function update($request, $categories)
    {
        if ($request->hot == 'on') {
            $hot = 0;
        } else {
            $hot = 1;
        }

        //NOTE - Lưu thông tin người dùng vào cơ sở dữ liệu
        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'parent_id' => $request->parent_id,
            'status' => $request->status,
            'description' => $request->description,
            'hot' => $hot,
            'image' => $request->image,
            'user_id' => Auth::id(),
        ];

        //NOTE - Lưu vào cơ sở dữ liệu
        $dataUpdate = $categories->update($data);
        //NOTE - Thông báo
        if ($dataUpdate) {

            // Thông báo thành công
            flash()->success('Cập nhật danh mục thành công!');


            // Chuyển hướng trang
            return redirect()->route('ecommerce_module.categories.index');
        } else {
            // Thông báo thất bại
            flash()->error('Cập nhật danh mục thất bại! Vui lòng đợi trong ít phút');
            // Chuyển hướng trang
            return redirect()->back();
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
            $changeStatus = Categories::find($id)->update(['status' => !$request->value]);

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

            foreach ($ids as $id) {
                $categories = Categories::find($id);

                if ($categories->children()->exists()) {
                    $childrenCategories = $categories->children;

                    foreach ($childrenCategories as $children) {
                        $children->saveAsRoot();
                    }
                }

                // Xóa node cha
                $dataDelete = $categories->delete();
            };

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
        } catch (\Exception $e) {
            // Thông báo lỗi xử lý
            return response()->json([
                'message' => 'Lỗi hệ thống vui lòng thử lại sau!'
            ], 500);
        }
    }

    //NOTE - Xóa danh mục đang chọn
    public function deleteRow($request)
    {
        // Xử lý ngoại lệ
        try {
            // Lấy id
            $id = $request->id;

            // Xóa tài khoản

            $categories = Categories::find($id);


            $childrenCategories = $categories->children;

            foreach ($childrenCategories as $children) {
                $children->saveAsRoot();
            }

            // Xóa node cha
            $dataDelete = $categories->delete();

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
        } catch (\Exception $e) {
            // Thông báo lỗi xử lý
            return response()->json([
                'message' => 'Lỗi hệ thống vui lòng thử lại sau!'
            ], 500);
        }
    }

    public function getCategoriesSelect()
    {
        return Categories::withDepth()->get()->toFlatTree();
    }

    public function getAllUsersSelect()
    {
        return User::select(['id', 'name'])->get();
    }

    public function detaiProductCategories($request)
    {
        $id = $request->get('id');

        // Lấy danh mục với sản phẩm và biến thể của sản phẩm
        $categoriId = Categories::find($id);

        $categories = $categoriId->products->select(['id', 'name', 'avatar']);

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($categories);
    }
}
