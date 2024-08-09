<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Backend\PropertieService;
use App\Http\Requests\Backend\PropertiesRequest;
use App\Models\Properties;

class PropertiesController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new PropertieService();
    }


    /**
     * Hiển thị danh sách tài nguyên.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Lấy danh sách thuộc tính theo cha.
         *
         * @var array $getPropertiesSelectByParent
         */
        $getPropertiesSelectByParent = $this->service->getPropertiesSelectByParent();

        /**
         * Trả về view danh sách thuộc tính với dữ liệu danh sách thuộc tính theo cha.
         *
         * @return \Illuminate\View\View
         */
        return view('backend.properties.index', compact('getPropertiesSelectByParent'));
    }

    /**
     * Lấy dữ liệu cho bảng quản lý thuộc tính.
     *
     * Phương thức này chịu trách nhiệm xử lý việc lấy dữ liệu cho bảng quản lý thuộc tính.
     * Nó nhận một đối tượng Request làm tham số, chứa dữ liệu đầu vào cho truy vấn.
     *
     * @param Request $request Đối tượng Request chứa dữ liệu đầu vào cho truy vấn.
     *
     * @return mixed Kết quả của thao tác truy xuất dữ liệu. Kết quả này có thể là một phản hồi JSON, một mảng dữ liệu, hoặc bất kỳ định dạng nào khác.
     */
    public function getData(Request $request)
    {
        return $this->service->getData($request);
    }

    /**
     * Hiển thị trang tạo mới thuộc tính.
     *
     * Phương thức này trả về view để tạo mới thuộc tính.
     * Nó sử dụng dịch vụ để lấy danh sách các thuộc tính để hiển thị trong select box.
     *
     * @return \Illuminate\View\View Trả về view tạo mới thuộc tính với dữ liệu danh sách thuộc tính.
     */
    public function create()
    {
        $getPropertiesSelect = $this->service->getPropertiesSelect();
        return view('backend.properties.create', compact('getPropertiesSelect'));
    }

    /**
     * Lưu mới một thuộc tính vào cơ sở dữ liệu.
     *
     * Phương thức này nhận một đối tượng PropertiesRequest làm tham số, chứa dữ liệu đầu vào cho thuộc tính mới.
     * Nó sử dụng dịch vụ để lưu thông tin thuộc tính vào cơ sở dữ liệu.
     *
     * @param PropertiesRequest $request Đối tượng chứa dữ liệu đầu vào cho thuộc tính mới.
     *
     * @return mixed Kết quả của thao tác lưu mới. Thông thường, kết quả này là một đối tượng Response hoặc một mảng dữ liệu.
     */
    public function store(PropertiesRequest $request)
    {
        return $this->service->store($request);
    }

    /**
     * Hiển thị trang chỉnh sửa thuộc tính.
     *
     * Phương thức này trả về view để chỉnh sửa thông tin của một thuộc tính đã tồn tại.
     * Nó sử dụng dịch vụ để lấy danh sách các thuộc tính để hiển thị trong select box.
     *
     * @param Properties $properties Đối tượng thuộc tính cần chỉnh sửa.
     *
     * @return \Illuminate\View\View Trả về view chỉnh sửa thuộc tính với dữ liệu của thuộc tính và danh sách thuộc tính.
     */
    public function edit(Properties $properties)
    {
        $getPropertiesSelect = $this->service->getPropertiesSelect();
        return view('backend.properties.edit', compact(['getPropertiesSelect', 'properties']));
    }

    /**
     * Cập nhật thông tin của một thuộc tính đã tồn tại trong cơ sở dữ liệu.
     *
     * Phương thức này nhận một đối tượng PropertiesRequest và một đối tượng Properties làm tham số.
     * Đối tượng PropertiesRequest chứa dữ liệu đầu vào cho thuộc tính cần cập nhật,
     * trong khi đối tượng Properties là thuộc tính cần cập nhật.
     *
     * @param PropertiesRequest $request Đối tượng chứa dữ liệu đầu vào cho thuộc tính cần cập nhật.
     * @param Properties $properties Đối tượng thuộc tính cần cập nhật.
     *
     * @return mixed Kết quả của thao tác cập nhật. Thông thường, kết quả này là một đối tượng Response hoặc một mảng dữ liệu.
     */
    public function update(PropertiesRequest $request, Properties $properties)
    {
        return $this->service->update($request, $properties);
    }

    /**
     * Thay đổi trạng thái của một thuộc tính trong cơ sở dữ liệu.
     *
     * Phương thức này nhận một đối tượng Request làm tham số, chứa dữ liệu cần thay đổi trạng thái.
     * Sau đó, nó gọi phương thức toggleStatus của đối tượng dịch vụ để thực hiện thao tác thay đổi trạng thái thực sự.
     *
     * @param Request $request Đối tượng Request chứa dữ liệu cần thay đổi trạng thái.
     *
     * @return mixed Kết quả của thao tác thay đổi trạng thái. Kết quả này có thể là một đối tượng Response hoặc một mảng dữ liệu.
     */
    public function toggleStatus(Request $request)
    {
        return $this->service->toggleStatus($request);
    }

    /**
     * Xóa nhiều thuộc tính cùng lúc từ cơ sở dữ liệu.
     *
     * Phương thức này nhận một đối tượng Request làm tham số, chứa dữ liệu để xác định các thuộc tính cần xóa.
     * Sau đó, nó gọi phương thức deleteAll của đối tượng dịch vụ để thực hiện thao tác xóa thực sự.
     *
     * @param Request $request Đối tượng Request chứa dữ liệu để xác định các thuộc tính cần xóa.
     *
     * @return mixed Kết quả của thao tác xóa nhiều thuộc tính. Kết quả này có thể là một đối tượng Response hoặc một mảng dữ liệu.
     */
    public function deleteAll(Request $request)
    {
        return $this->service->deleteAll($request);
    }


    /**
     * Xóa một dòng thuộc tính từ cơ sở dữ liệu.
     *
     * Phương thức này nhận một đối tượng Request làm tham số, chứa dữ liệu để xác định dòng thuộc tính cần xóa.
     * Sau đó, nó gọi phương thức deleteRow của đối tượng dịch vụ để thực hiện thao tác xóa thực sự.
     *
     * @param Request $request Đối tượng Request chứa dữ liệu để xác định dòng thuộc tính cần xóa.
     *
     * @return mixed Kết quả của thao tác xóa dòng thuộc tính. Kết quả này có thể là một đối tượng Response hoặc một mảng dữ liệu.
     */
    public function deleteRow(Request $request)
    {
        return $this->service->deleteRow($request);
    }
}
