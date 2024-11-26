<?php


namespace App\Services\Backend;

use Carbon\Carbon;
use App\Models\Properties;
use App\Helpers\FormatFunction;
use Yajra\DataTables\Facades\DataTables;

class PropertieService
{
    public function getData($request)
    {
        $searchInput = $request->searchInput;
        $searchStatus = $request->searchStatus;
        $searchParent = $request->searchParent;

        $filer = [];

        $query =  Properties::query();

        $query = $query->withDepth()
            ->defaultOrder();

        if ($request->has('searchInput') && isset($searchInput)) {
            $query->where(function ($query) use ($searchInput) {
                $query->where('name', 'like', '%' . $searchInput . '%');
            });
        }

        if ($request->has('searchStatus') && isset($searchStatus)) {

            $filer[] = ['status', '=', $searchStatus];
        }

        if ($request->has('searchParent') && isset($searchParent)) {

            $node = Properties::find($searchParent);
            if ($node) {
                // Get ancestors and descendants
                $ancestors = $node->ancestors()->get();
                $descendants = $node->descendants()->get();
                $nodes = $ancestors->merge([$node])->merge($descendants);

                // Filter the query to include only these nodes
                $query->whereIn('id', $nodes->pluck('id'));
            }
        }

        if (!empty($filer)) {
            $query = $query->where($filer);
        }

        $query =  $query->get()->toFlatTree();


        return DataTables::of($query)
            ->addColumn('name', function ($properties) {
                return FormatFunction::formatTitleCategories($properties);
            })
            ->addColumn('parent_id', function ($properties) {
                return $properties->slug;
            })
            ->addColumn('status', function ($properties) {
                return FormatFunction::formatBadge($properties->status);
            })
            ->addColumn('action', function ($properties) {
                $actions = '';

                // Kiểm tra quyền cập nhật thuộc tính
                if (auth()->user()->can('Cập nhật thuộc tính')) {
                    $actions .= '<a href="' . route('ecommerce_module.properties.edit', ['properties' => $properties]) . '"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-400 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-400 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                    </svg>
                </a>';
                }

                // Kiểm tra quyền xóa thuộc tính
                if (auth()->user()->can('Xoá thuộc tính')) {
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

            ->rawColumns(['name', 'status',  'action'])
            ->make(true);
    }


    public function store($request)
    {
        // Xử lý ngoại lệ
        try {
            //NOTE - Lưu thông tin người dùng vào cơ sở dữ liệu
            $data = [
                'name' => $request->name,
                'slug' => $request->slug,
                'parent_id' => $request->parent_id,
                'value' => $request->value,
            ];

            //NOTE - Lưu vào cơ sở dữ liệu
            $dataInsert = Properties::create($data);
            //NOTE - Thông báo
            if ($dataInsert) {
                // Thông báo thành công
                flash()->success('Tạo mới thuộc tính thành công!');
                // Chuyển hướng trang
                return redirect()->route('ecommerce_module.properties.index');
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

    public function update($request, $properties)
    {
        // Xử lý ngoại lệ
        try {
            //NOTE - Lưu thông tin người dùng vào cơ sở dữ liệu
            $data = [
                'name' => $request->name,
                'slug' => $request->slug,
                'parent_id' => $request->parent_id,
                'status' => $request->status,
            ];

            //NOTE - Lưu vào cơ sở dữ liệu
            $dataInsert = $properties->update($data);
            //NOTE - Thông báo
            if ($dataInsert) {
                // Thông báo thành công
                flash()->success('Cập nhật thuộc tính thành công!');
                // Chuyển hướng trang
                return redirect()->route('ecommerce_module.properties.index');
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


    //NOTE - Cập nhật toggle status
    public function toggleStatus($request)
    {
        // Xử lý ngoại lệ
        try {
            // Lấy ID
            $id = $request->id;

            // Xử lý cập nhật status
            $changeStatus = Properties::find($id)->update(['status' => !$request->value]);

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
                $properties = Properties::find($id);

                if ($properties->children()->exists()) {
                    $childrenProperties = $properties->children;

                    foreach ($childrenProperties as $children) {
                        $children->delete();
                    }
                }

                // Xóa node cha
                $dataDelete = $properties->delete();
            };

            if ($dataDelete) {
                // Thông báo thành công
                return response()->json([
                    'message' => 'Xóa thuộc tính thành công!'
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

            $properties = Properties::find($id);


            $childrenProperties = $properties->children;

            foreach ($childrenProperties as $children) {
                $children->delete();
            }

            // Xóa node cha
            $dataDelete = $properties->delete();
            if ($dataDelete) {
                // Thông báo thành công
                return response()->json([
                    'message' => 'Xóa thuộc tính thành công!'
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

    public function getPropertiesSelect()
    {
        return Properties::withDepth()->get()->whereNull('parent_id')->toFlatTree();
    }

    public function getPropertiesSelectByParent()
    {
        return Properties::whereNull('parent_id')->get();
    }
}
