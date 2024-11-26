<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UserRequest;
use App\Models\User;
use App\Services\Backend\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new UserService();
    }

    /**
     * Hiển thị trang danh sách người dùng.
     *
     * Phương thức này chịu trách nhiệm trả về giao diện hiển thị danh sách người dùng trong phần quản trị.
     * Nó trả về view 'backend.user.index' chứa mã HTML và JavaScript cần thiết để hiển thị danh sách người dùng.
     *
     * @return \Illuminate\View\View Giao diện hiển thị danh sách người dùng.
     */
    public function index()
    {
        return view('backend.user.index');
    }


    /**
     * Lấy dữ liệu cho bảng người dùng trong phần quản trị.
     *
     * Phương thức này chịu trách nhiệm xử lý yêu cầu AJAX từ bảng người dùng trong phần quản trị.
     * Nó lấy dữ liệu cần thiết từ cơ sở dữ liệu và trả về định dạng có thể dễ dàng tiêu thụ bởi bảng.
     *
     * @param Request $request Đối tượng yêu cầu chứa các tham số của bảng như tìm kiếm, phân trang và sắp xếp.
     *
     * @return mixed Kết quả của việc truy xuất dữ liệu cho bảng người dùng.
     *               Nếu dữ liệu được truy xuất thành công, nó sẽ trả về một phản hồi JSON chứa dữ liệu và thông tin cần thiết cho bảng.
     *               Nếu có bất kỳ lỗi nào xảy ra trong quá trình truy xuất, nó sẽ trả về một phản hồi lỗi phù hợp.
     */
    public function getData(Request $request)
    {
        return $this->service->getDatatable($request);
    }


    /**
     * Hiển thị trang tạo mới người dùng.
     *
     * Phương thức này chịu trách nhiệm trả về giao diện hiển thị để tạo mới người dùng trong phần quản trị.
     * Nó trả về view 'backend.user.create' chứa mã HTML và JavaScript cần thiết để tạo mới người dùng.
     *
     * @return \Illuminate\View\View Giao diện hiển thị để tạo mới người dùng.
     */
    public function create()
    {
        $getRole = $this->service->GetRole();
        return view('backend.user.create',compact('getRole'));
    }


    /**
     * Lưu mới người dùng vào cơ sở dữ liệu.
     *
     * Phương thức này chịu trách nhiệm xử lý yêu cầu từ giao diện tạo mới người dùng trong phần quản trị.
     * Nó sẽ sử dụng dịch vụ UserService để lưu mới người dùng vào cơ sở dữ liệu.
     *
     * @param UserRequest $request Đối tượng yêu cầu chứa dữ liệu của người dùng mới.
     *                             Nó đã được kiểm tra và đã hợp lệ theo UserRequest.
     *
     * @return mixed Kết quả của việc lưu mới người dùng.
     *               Nếu lưu mới thành công, nó sẽ trả về một phản hồi JSON chứa thông báo thành công.
     *               Nếu có bất kỳ lỗi nào xảy ra trong quá trình lưu mới, nó sẽ trả về một phản hồi lỗi phù hợp.
     */
    public function store(UserRequest $request)
    {
        return $this->service->store($request);
    }

    /**
     * Chuyển đổi trạng thái của người dùng (kích hoạt/vô hiệu hóa).
     *
     * Phương thức này chịu trách nhiệm xử lý yêu cầu AJAX từ giao diện để chuyển đổi trạng thái của người dùng.
     * Nó sử dụng dịch vụ UserService để thực hiện thay đổi trạng thái của người dùng trong cơ sở dữ liệu.
     *
     * @param Request $request Đối tượng yêu cầu chứa thông tin của người dùng và trạng thái mới.
     *                         Nó đã được kiểm tra và đã hợp lệ theo yêu cầu của ứng dụng.
     *
     * @return mixed Kết quả của việc chuyển đổi trạng thái của người dùng.
     *               Nếu chuyển đổi thành công, nó sẽ trả về một phản hồi JSON chứa thông báo thành công.
     *               Nếu có bất kỳ lỗi nào xảy ra trong quá trình chuyển đổi, nó sẽ trả về một phản hồi lỗi phù hợp.
     */

    public function toggleStatus(Request $request)
    {
        return $this->service->toggleStatus($request);
    }

    /**
     * Hiển thị trang chỉnh sửa thông tin của một người dùng.
     *
     * Phương thức này chịu trách nhiệm trả về giao diện hiển thị để chỉnh sửa thông tin của một người dùng trong phần quản trị.
     * Nó trả về view 'backend.user.edit' chứa mã HTML và JavaScript cần thiết để chỉnh sửa thông tin của người dùng.
     *
     * @param mixed $user Đối tượng người dùng hoặc ID của người dùng cần chỉnh sửa.
     *                    Nếu truyền vào đối tượng người dùng, phương thức sẽ sử dụng đối tượng đó để hiển thị thông tin.
     *                    Nếu truyền vào ID của người dùng, phương thức sẽ tìm kiếm và lấy thông tin của người dùng từ cơ sở dữ liệu.
     *
     * @return \Illuminate\View\View Giao diện hiển thị để chỉnh sửa thông tin của người dùng.
     *                               Nếu người dùng không tồn tại, nó sẽ trả về một trang lỗi 404.
     */
    public function edit(User $user)
    {
        $getRole = $this->service->GetRole();
        return view('backend.user.edit', compact(['user','getRole']));
    }


    /**
     * Cập nhật thông tin của một người dùng trong cơ sở dữ liệu.
     *
     * Phương thức này chịu trách nhiệm xử lý yêu cầu từ giao diện chỉnh sửa thông tin của người dùng trong phần quản trị.
     * Nó sử dụng dịch vụ UserService để cập nhật thông tin của người dùng trong cơ sở dữ liệu.
     *
     * @param UserRequest $request Đối tượng yêu cầu chứa dữ liệu của người dùng cần cập nhật.
     *                             Nó đã được kiểm tra và đã hợp lệ theo UserRequest.
     *
     * @param User $user Đối tượng người dùng cần cập nhật.
     *                   Nó đã được tìm kiếm và lấy thông tin từ cơ sở dữ liệu.
     *
     * @return mixed Kết quả của việc cập nhật thông tin của người dùng.
     *               Nếu cập nhật thành công, nó sẽ trả về một phản hồi JSON chứa thông báo thành công.
     *               Nếu có bất kỳ lỗi nào xảy ra trong quá trình cập nhật, nó sẽ trả về một phản hồi lỗi phù hợp.
     */
    public function update(UserRequest $request, User $user)
    {
        return $this->service->update($request, $user);
    }


    /**
     * Xóa nhiều người dùng khỏi cơ sở dữ liệu.
     *
     * Phương thức này chịu trách nhiệm xử lý yêu cầu AJAX từ giao diện để xóa nhiều người dùng cùng lúc.
     * Nó sử dụng dịch vụ UserService để thực hiện xóa nhiều người dùng trong cơ sở dữ liệu.
     *
     * @param Request $request Đối tượng yêu cầu chứa danh sách ID của người dùng cần xóa.
     *                         Nó đã được kiểm tra và đã hợp lệ theo yêu cầu của ứng dụng.
     *
     * @return mixed Kết quả của việc xóa nhiều người dùng.
     *               Nếu xóa thành công, nó sẽ trả về một phản hồi JSON chứa thông báo thành công.
     *               Nếu có bất kỳ lỗi nào xảy ra trong quá trình xóa, nó sẽ trả về một phản hồi lỗi phù hợp.
     */
    public function deleteAll(Request $request)
    {
        return $this->service->deleteAll($request);
    }

    /**
     * Xóa một người dùng khỏi cơ sở dữ liệu.
     *
     * Phương thức này chịu trách nhiệm xử lý yêu cầu AJAX từ giao diện để xóa một người dùng.
     * Nó sử dụng dịch vụ UserService để thực hiện xóa một người dùng trong cơ sở dữ liệu.
     *
     * @param Request $request Đối tượng yêu cầu chứa ID của người dùng cần xóa.
     *                         Nó đã được kiểm tra và đã hợp lệ theo yêu cầu của ứng dụng.
     *
     * @return mixed Kết quả của việc xóa một người dùng.
     *               Nếu xóa thành công, nó sẽ trả về một phản hồi JSON chứa thông báo thành công.
     *               Nếu có bất kỳ lỗi nào xảy ra trong quá trình xóa, nó sẽ trả về một phản hồi lỗi phù hợp.
     */
    public function deleteRow(Request $request)
    {
        return $this->service->deleteRow($request);
    }

    /**
     * Xuất dữ liệu người dùng ra file Excel.
     *
     * Phương thức này chịu trách nhiệm xuất dữ liệu người dùng ra file Excel.
     * Nó sử dụng dịch vụ UserService để thực hiện việc này.
     *
     * @return mixed Kết quả của việc xuất dữ liệu.
     *               Nếu xuất dữ liệu thành công, nó sẽ trả về một tệp Excel chứa dữ liệu người dùng.
     *               Nếu có bất kỳ lỗi nào xảy ra trong quá trình xuất dữ liệu, nó sẽ trả về một phản hồi lỗi phù hợp.
     */
    public function export(Request $request)
    {
        return $this->service->exportExcel($request);
    }

    /**
     * Xuất dữ liệu người dùng từ file Excel vào cơ sở dữ liệu.
     *
     * Phương thức này chịu trách nhiệm xử lý yêu cầu tải lên file Excel và nhập dữ liệu người dùng vào cơ sở dữ liệu.
     * Nó sử dụng dịch vụ UserService để thực hiện việc này.
     *
     * @param Request $request Đối tượng yêu cầu chứa file Excel cần nhập dữ liệu.
     *                         Nó đã được kiểm tra và đã hợp lệ theo yêu cầu của ứng dụng.
     *
     * @return mixed Kết quả của việc nhập dữ liệu.
     *               Nếu nhập dữ liệu thành công, nó sẽ trả về một phản hồi JSON chứa thông báo thành công.
     *               Nếu có bất kỳ lỗi nào xảy ra trong quá trình nhập dữ liệu, nó sẽ trả về một phản hồi lỗi phù hợp.
     */
    public function import(Request $request)
    {
        return $this->service->importExcel($request);
    }
}
