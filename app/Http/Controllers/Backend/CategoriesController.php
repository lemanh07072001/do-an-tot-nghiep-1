<?php

namespace App\Http\Controllers\Backend;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Backend\CategoriesService;
use App\Http\Requests\Backend\CategoriesRequest;

class CategoriesController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new CategoriesService();
    }


    /**
     * Hiển thị danh sách các tài nguyên.
     *
     * Hàm này lấy tất cả các danh mục và hiển thị chúng theo cách phân trang.
     * Nó cũng lấy danh sách tất cả các người dùng để sử dụng trong trường select của giao diện chỉ mục.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getAllUsersSelect = $this->service->getAllUsersSelect();
        return view('backend.categories.index', compact('getAllUsersSelect'));
    }


    /**
     * Lấy dữ liệu cho bảng quản lý danh mục sử dụng phân trang và tìm kiếm.
     *
     * Hàm này nhận yêu cầu HTTP và trả về dữ liệu đã được xử lý cho bảng quản lý.
     * Dữ liệu bao gồm các cột như tên danh mục, trạng thái, và các hành động để chỉnh sửa hoặc xóa.
     *
     * @param \Illuminate\Http\Request $request Yêu cầu HTTP chứa thông tin phân trang, tìm kiếm, và các điều kiện lọc.
     * @return \Illuminate\Http\JsonResponse Dữ liệu đã được xử lý và đã sẵn sàng để hiển thị trong bảng quản lý.
     */
    public function getData(Request $request)
    {
        return $this->service->getData($request);
    }

    /**
     * Hiển thị biểu mẫu để tạo mới một tài nguyên.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $getCategoriesSelect = $this->service->getCategoriesSelect();
        return view('backend.categories.create', compact(['getCategoriesSelect']));
    }

    /**
     * Lưu mới một danh mục mới vào cơ sở dữ liệu.
     *
     * Hàm này nhận yêu cầu HTTP chứa dữ liệu của danh mục mới,
     * sau đó gọi đến dịch vụ để lưu dữ liệu vào cơ sở dữ liệu.
     *
     * @param \Illuminate\Http\Request $request Yêu cầu HTTP chứa dữ liệu của danh mục mới.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector Trả về chuyển hướng đến trang danh sách danh mục nếu lưu thành công.
     * @throws \Exception Ném ngoại lệ nếu xảy ra lỗi khi lưu dữ liệu.
     */
    public function store(CategoriesRequest $request)
    {
        return $this->service->store($request);
    }

    /**
     * Hiển thị biểu mẫu để chỉnh sửa một danh mục đã tồn tại.
     *
     * Hàm này nhận đối tượng danh mục làm tham số và hiển thị biểu mẫu chỉnh sửa.
     * Biểu mẫu sẽ chứa dữ liệu của danh mục đã chọn và danh sách các danh mục khác để phục vụ cho việc chọn cha.
     *
     * @param \App\Models\Categories $categories Đối tượng danh mục cần chỉnh sửa.
     * @return \Illuminate\View\View Trả về giao diện chỉnh sửa danh mục với dữ liệu đã được truyền vào.
     */
    public function edit(Categories $categories)
    {
        $getCategoriesSelect = $this->service->getCategoriesSelect();

        return view('backend.categories.edit', compact(['getCategoriesSelect', 'categories']));
    }

    /**
     * Cập nhật thông tin của một danh mục đã tồn tại trong cơ sở dữ liệu.
     *
     * Hàm này nhận yêu cầu HTTP và đối tượng danh mục làm tham số.
     * Sau đó, nó gọi đến dịch vụ để cập nhật dữ liệu của danh mục trong cơ sở dữ liệu.
     *
     * @param \Illuminate\Http\Request $request Yêu cầu HTTP chứa dữ liệu của danh mục đã chỉnh sửa.
     * @param \App\Models\Categories $categories Đối tượng danh mục cần cập nhật.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector Trả về chuyển hướng đến trang danh sách danh mục nếu cập nhật thành công.
     * @throws \Exception Ném ngoại lệ nếu xảy ra lỗi khi cập nhật dữ liệu.
     */
    public function update(CategoriesRequest $request, Categories $categories)
    {
        return $this->service->update($request, $categories);
    }

    /**
     * Thay đổi trạng thái của một hoặc nhiều danh mục trong cơ sở dữ liệu.
     *
     * Hàm này nhận yêu cầu HTTP chứa mảng ID của các danh mục cần thay đổi trạng thái.
     * Sau đó, nó gọi đến dịch vụ để thay đổi trạng thái của các danh mục trong cơ sở dữ liệu.
     *
     * @param \Illuminate\Http\Request $request Yêu cầu HTTP chứa mảng ID của các danh mục cần thay đổi trạng thái.
     * @return \Illuminate\Http\JsonResponse Trả về đối tượng JSON chứa thông tin về kết quả thay đổi trạng thái.
     * @throws \Exception Ném ngoại lệ nếu xảy ra lỗi khi thay đổi trạng thái của các danh mục.
     */
    public function toggleStatus(Request $request)
    {
        return $this->service->toggleStatus($request);
    }

    /**
     * Xóa tất cả các danh mục đã chọn từ cơ sở dữ liệu.
     *
     * Hàm này nhận yêu cầu HTTP chứa mảng ID của các danh mục cần xóa.
     * Sau đó, nó gọi đến dịch vụ để xóa các danh mục đã chọn trong cơ sở dữ liệu.
     *
     * @param \Illuminate\Http\Request $request Yêu cầu HTTP chứa mảng ID của các danh mục cần xóa.
     * @return \Illuminate\Http\JsonResponse Trả về đối tượng JSON chứa thông tin về kết quả xóa.
     * @throws \Exception Ném ngoại lệ nếu xảy ra lỗi khi xóa các danh mục.
     */
    public function deleteAll(Request $request)
    {
        return $this->service->deleteAll($request);
    }


    /**
     * Xóa một danh mục đã chọn từ cơ sở dữ liệu.
     *
     * Hàm này nhận yêu cầu HTTP chứa ID của danh mục cần xóa.
     * Sau đó, nó gọi đến dịch vụ để xóa danh mục đã chọn trong cơ sở dữ liệu.
     *
     * @param \Illuminate\Http\Request $request Yêu cầu HTTP chứa ID của danh mục cần xóa.
     * @return \Illuminate\Http\JsonResponse Trả về đối tượng JSON chứa thông tin về kết quả xóa.
     * @throws \Exception Ném ngoại lệ nếu xảy ra lỗi khi xóa danh mục.
     */
    public function deleteRow(Request $request)
    {
        return $this->service->deleteRow($request);
    }

    public function detaiProductCategories(Request $request){
        return $this->service->detaiProductCategories($request);
    }
}
