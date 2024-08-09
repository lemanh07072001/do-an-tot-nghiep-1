<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BannerRequest;
use App\Models\Banner;
use App\Services\Backend\BannerService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new BannerService();
    }

    /**
     * Hiển thị danh sách tài nguyên.
     *
     * Phương thức này lấy danh sách tất cả các người dùng cho một hộp chọn và trả về view cho trang chỉ mục của quản lý banner.
     *
     * @return \Illuminate\View\View View cho trang chỉ mục của quản lý banner với dữ liệu hộp chọn người dùng.
     */
    public function index()
    {
        $getAllUsersSelect = $this->service->getAllUsersSelect();
        return view('backend.banner.index', compact('getAllUsersSelect'));
    }

    /**
     * Lấy dữ liệu cho bảng quản lý banner.
     *
     * Phương thức này xử lý yêu cầu Ajax để trả về dữ liệu cho bảng banner trong quản lý.
     * Nó sử dụng thư viện Yajra DataTables để phân trang, tìm kiếm và sắp xếp dữ liệu.
     *
     * @param Request $request Yêu cầu HTTP chứa thông tin phân trang, tìm kiếm và sắp xếp.
     * @return mixed Dữ liệu đã được định dạng để phù hợp với Yajra DataTables.
     */
    public function getData(Request $request)
    {
        return $this->service->getData($request);
    }

    /**
     * Hiển thị trang tạo mới banner.
     *
     * Phương thức này trả về view cho trang tạo mới banner.
     *
     * @return \Illuminate\View\View View cho trang tạo mới banner.
     */
    public function create()
    {
        return view('backend.banner.create');
    }

    /**
     * Lưu thông tin banner mới vào cơ sở dữ liệu.
     *
     * Phương thức này xử lý yêu cầu HTTP POST để lưu thông tin banner mới vào cơ sở dữ liệu.
     * Nó sử dụng dịch vụ BannerService để thực hiện nhiệm vụ lưu trữ.
     *
     * @param BannerRequest $request Yêu cầu HTTP chứa dữ liệu của banner.
     * @return mixed Trả về kết quả của việc lưu trữ banner. Thông thường, nó sẽ trả về đường dẫn đến trang chỉ mục của quản lý banner.
     */
    public function store(BannerRequest $request)
    {
        return $this->service->store($request);
    }

    /**
     * Hiển thị chi tiết của một banner.
     *
     * Phương thức này lấy thông tin chi tiết của một banner dựa trên ID và trả về view cho trang xem chi tiết.
     *
     * @param string $id ID của banner cần hiển thị.
     * @return \Illuminate\View\View View cho trang xem chi tiết của banner.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Hiển thị trang chỉnh sửa của một banner.
     *
     * Phương thức này lấy thông tin của một banner dựa trên ID và trả về view cho trang chỉnh sửa.
     *
     * @param Banner $banner Đối tượng Banner cần chỉnh sửa. Đối tượng này được lấy từ route model binding.
     * @return \Illuminate\View\View View cho trang chỉnh sửa của banner với dữ liệu của banner đã chọn.
     */
    public function edit(Banner $banner)
    {
        return view('backend.banner.edit', compact('banner'));
    }


    /**
     * Cập nhật thông tin của một banner trong cơ sở dữ liệu.
     *
     * Phương thức này xử lý yêu cầu HTTP PUT/PATCH để cập nhật thông tin của một banner dựa trên ID.
     * Nó sử dụng dịch vụ BannerService để thực hiện nhiệm vụ cập nhật.
     *
     * @param BannerRequest $request Yêu cầu HTTP chứa dữ liệu của banner.
     * @param Banner $banner Đối tượng Banner cần cập nhật. Đối tượng này được lấy từ route model binding.
     * @return mixed Trả về kết quả của việc cập nhật banner. Thông thường, nó sẽ trả về đường dẫn đến trang chỉ mục của quản lý banner.
     */
    public function update(BannerRequest $request, Banner $banner)
    {
        return $this->service->update($request, $banner);
    }


    /**
     * Toggles the status of a banner in the database.
     *
     * This function handles the HTTP PUT/PATCH request to toggle the status of a banner based on its ID.
     * It uses the BannerService to perform the status toggle operation.
     *
     * @param Request $request The HTTP request containing the banner data.
     * @return mixed The result of the status toggle operation. Typically, it returns a redirect to the index page of the banner management.
     */
    public function toggleStatus(Request $request)
    {
        return $this->service->toggleStatus($request);
    }

    /**
     * Deletes all selected banners from the database.
     *
     * This function handles the HTTP DELETE request to delete multiple banners at once.
     * It uses the BannerService to perform the deletion operation.
     *
     * @param Request $request The HTTP request containing the IDs of the banners to be deleted.
     * @return mixed The result of the deletion operation. Typically, it returns a redirect to the index page of the banner management.
     */
    public function deleteAll(Request $request)
    {
        return $this->service->deleteAll($request);
    }


    /**
     * Deletes a single banner from the database based on the provided request.
     *
     * This function handles the HTTP DELETE request to delete a single banner based on its ID.
     * It uses the BannerService to perform the deletion operation.
     *
     * @param Request $request The HTTP request containing the ID of the banner to be deleted.
     * @return mixed The result of the deletion operation. Typically, it returns a redirect to the index page of the banner management.
     */
    public function deleteRow(Request $request)
    {
        return $this->service->deleteRow($request);
    }
}
