<?php


namespace App\Helpers;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\Status;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Properties;
use Illuminate\Support\Facades\Log;

class FormatFunction
{
    public static function formatDate($date)
    {
        return Carbon::parse($date)->format('d-m-Y H:i:s');
    }

    public static function getDatetime()
    {
        return Carbon::now()->toDateTimeString();
    }

    public static function formatAvatar($data)
    {
        // avatar - online
        if ($data->avatar != null) {
            return '
                <img class="inline-block w-8 h-8 rounded-full" src="" alt="Image Description">
            ';
        } else {
            return '
                <img class="inline-block w-8 h-8 rounded-full" src="' . asset('images/noAvatar.png') . '" alt="Image Description">
            ';
        }
    }

    public static function formatImage($data)
    {
        // avatar - online
        if ($data != null) {
            return '
                <div class="avatar ">
                    <img src="' . $data . '" alt="" class=" rounded-circle">
                </div>
            ';
        }
    }

    public static function formatTitleCategories($data)
    {
        $html = '';
        $parent_name = '';

        if ($data->parent_id == null) {
            $parent_name = '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Danh mục cha</span>';
        } else {
            $parent_name = '<span class="bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-pink-900 dark:text-pink-300">Danh mục cha: ' . $data->parent->name . '</span>';
        };

        $html .= '<div >';
        $html .= str_repeat("|---", $data->depth) . $data->name;
        $html .= '<div>' . $parent_name . '</div>'; // Đã sửa lỗi ở đây
        $html .= '</div>';

        return $html;
    }

    public static function formatTitleProperties($data)
    {
        $html = '';
        $parent_name = '';

        if ($data->parent_id == null) {
            $parent_name = '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Danh mục cha</span>';
        } else {
            $parent_name = '<span class="bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-pink-900 dark:text-pink-300">Danh mục cha: ' . $data->parent->name . '</span>';
        };

        $html .= '<div >';
        $html .= str_repeat("|---", $data->depth) . $data->name;
        $html .= '<div>' . $parent_name . '</div>'; // Đã sửa lỗi ở đây
        $html .= '</div>';

        return $html;
    }

    public static function formatDateSafe($data)
    {
        if (!empty($data->date_start) && !empty($data->date_end)) {
            return '<div class="text-xs font-medium">' . self::formatDate($data->date_start) . '</div>' . '<div class="text-xs font-medium">' . self::formatDate($data->date_end) . '</div>';
        } else {
            return '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Vĩnh viễn</span>';
        }
    }



    public static function formatBadge($data)
    {
        $checked = ($data == '0') ? 'checked' : '';
        return '
            <div class="flex align-center">
                <label class="inline-flex items-center cursor-pointer">
                  <input type="checkbox" value="' . $data . '" data-toggle="status" class="sr-only peer" ' . $checked . '>
                     <div class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                </label>
            </div>
        ';
    }

    public static function formatVeryEmail($data)
    {
        if ($data == null) {
            return '<span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Chưa kích hoạt</span>';
        } else {
            return '<span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Đã kích hoạt</span>';
        }
    }

    public static function actionTable()
    {
        return '
           <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-400 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-400 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                <svg class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
            </a>

            <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                <svg class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            </button>
        ';
    }

    public static function formatTitleProduct($data)
    {
        return '

            <div class="flex items-center gap-4">
                <img class="w-10 h-10 rounded-full" src="' . env('APP_URL') . $data->avatar . '" alt="">
                <div class="font-medium text-sky-400">
                    <div>' . $data->name . '</div>
                    <div class="text-sm text-red-400  dark:text-gray-400">Danh mục: <span class="text-slate-400">' . $data->categories->name . '</span></div>
                </div>
            </div>
        ';
    }

    public static function formatImagesProduct($data)
    {
        $imageArray = explode(", ", $data->images);
        $html = "<div class='flex -space-x-4 rtl:space-x-reverse'>";

        // Lấy tối đa 3 phần tử đầu tiên từ mảng
        $firstThreeImages = array_slice($imageArray, 0, 3);

        // Hiển thị 3 hình ảnh đầu tiên
        foreach ($firstThreeImages as $image) {
            $html .= "<img class='modelPreviewImages w-10 h-10 border-2 border-white rounded-full dark:border-gray-800' src='" . env('APP_URL') . $image . "' alt='" . $data->name . "'>";
        };

        // Nếu mảng có nhiều hơn 3 phần tử, hiển thị số lượng hình ảnh còn lại
        if (count($imageArray) > 3) {
            $remainingCount = count($imageArray) - 3;
            $html .= "<a class='modelPreviewImages flex items-center justify-center w-10 h-10 text-xs font-medium text-white bg-gray-700 border-2 border-white rounded-full hover:bg-gray-600 ' href='#'>" . $remainingCount . "</a>";
        }

        $html .= "</div>";

        return $html;
    }

    public static function formatPriceProduct($data)
    {
        if ($data != '0') {
            return '<div class="font-semibold text-sm">' . number_format($data, 0, ',', '.') . ' đ' . '</div>';
        } else {
            return '<span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Không khuyến mãi</span>';
        }
    }

    public static function formatPrice($data)
    {
        return str_replace('.', '', $data);
    }



    public static function paymentFormOrder($data)
    {
        if ($data->payment_method == 'cash_on_delivery') {
            return '<span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded  border border-blue-400">Thanh toán khi nhận hàng</span>';
        } else if ($data->payment_method == 'payment_transfer') {
            return '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded  border border-green-400">Thanh toán chuyển khoản</span>';
        } else {
            return '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded  border border-red-400">Lỗi thanh toán</span>';
        }
    }

    public static function statusFormOrder($data)
    {
        $html = '';

        $html .= '
        <select id="status-order-' . $data->id . '" data-id="' . $data->id . '" class="block w-2/3 p-1.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
            <option value="pending" ' . ($data->status == 'pending' ? 'selected' : '') . '>Đang chờ xử lý</option>
            <option value="completed" ' . ($data->status == 'completed' ? 'selected' : '') . '>Đã hoàn thành</option>
            <option value="cancelled" ' . ($data->status == 'cancelled' ? 'selected' : '') . '>Đã huỷ</option>
        </select>
    ';

        return $html;
    }


    public static function formatTitleVariantProduct($data)
    {
        // Bắt đầu xây dựng HTML đầu ra
        $output = '<div class="flex items-center gap-4">';

        // Thêm ảnh nếu tồn tại
        if (!empty($data['avatar'])) {
            $output .= '<img class="w-10 h-10 rounded-full" src="' . env('APP_URL') . $data['avatar'] . '" alt="">';
        }

        // Tiếp tục xây dựng HTML
        $output .= '<div class="font-medium text-sky-400">';

        // Thêm tiêu đề nếu không có ảnh
        if (empty($data['avatar'])) {
            $output .= '<div class="title ml-[40px]">' . htmlspecialchars($data['name']) . '</div>';
        } else {
            $output .= htmlspecialchars($data['name']);
        }

        // Đóng thẻ div
        $output .= '</div></div>';

        return $output;
    }

    public static function formatVariantProduct($data, $name = '', $number = false, $format = 'VND')
    {
        $html = '';
        if (!empty($data[$name])) {
            if ($number == false) {
                $html .= '<div>' . $data[$name] . '</div>';
            } else {
                $html .= number_format($data[$name], 0, ',', '.') . ' ' . $format;
            }
        } else {
            $html .= '---';
        }

        return $html;
    }




    public static function formatCountProductCategories($data)
    {
        $totalProductsByCategory = count($data->products);
        if ($totalProductsByCategory) {
            return '<span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">' . $totalProductsByCategory . ' sản phẩm</span>';
        }
    }


    public static function formatSaleVoucher($data)
    {
        if ($data->discount_type == '%') {
            return '<span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">' . $data->value_reduction . ' %</span>';
        } else {
            return '<span class="bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400">' . number_format($data->value_reduction, 0, ',', '.') . ' đ' . '</span>';
        }
    }

    public static function formatQuantityVoucher($data)
    {
        if ($data->limit != null) {
            return '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">' . $data->unlimited . ' / ' . $data->limit . ' voucher</span>';
        } else {
            return '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">' . $data->unlimited . ' / Không giới hạn</span>';
        }
    }

    public static function formatTitleComment($data)
    {
        $html = '';
        $isAdmin = '';

        if ($data->user->is_admin == 1) {
            $isAdmin .= '<span class="bg-purple-100 text-purple-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">Admin</span>';
        }

        // Xác định padding dựa trên depth
        $paddingClass = 'pl-' . ($data->depth * 3); // Mỗi độ sâu thêm 4 đơn vị padding

        $html .= '<div class="overflow-hidden text-base font-normal truncate ' . $paddingClass . '"><span class="font-semibold text-black">Họ tên</span>: ' . $data->user->name . ' ' . $isAdmin . '</div>';
        $html .= '<div class="overflow-hidden text-base font-normal truncate ' . $paddingClass . '"><span class="font-semibold text-black">Email</span>: ' . $data->user->email . '</div>';

        return $html;
    }

    public static function formatStatusComment($data)
    {
        if ($data->status == '0') {
            return '<span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Đã duyệt</span>';
        } else {
            return '<span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Chưa duyệt</span>';
        }
    }

    public static function formatTitleMessage($data)
    {
        $buttonHtml = '<button type="button" class="openModalMessage text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Chi tiết</button>';
        return $buttonHtml;
    }


    public static function formatTitleContact($data)
    {
        $html = '';


        $html .= '<div class="overflow-hidden text-base font-normal truncate "><span class="font-semibold text-black">Họ tên</span>: ' . $data->name . ' </div>';
        $html .= '<div class="overflow-hidden text-base font-normal truncate"><span class="font-semibold text-black">Email</span>: ' . $data->email . '</div>';
        $html .= '<div class="overflow-hidden text-base font-normal truncate"><span class="font-semibold text-black">Phone</span>: ' . $data->phone . '</div>';

        return $html;
    }

    public static function formatStatusCContent($data)
    {
        if ($data->status === 0) {
            return '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Chưa trả lời</span>';
        } else if ($data->status === 1) {
            return '<span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Đã trả lời</span>';
        } else {
            return '<span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Đã xem</span>';
        }
    }

    public static function formatDataProductVariantsForDataTable($data)
    {


        $dataProducts = [];

        foreach ($data as $item) {
            $dataProducts[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'avatar' => $item['avatar'],
            ];

            if (!empty($item['children'])) {
                foreach ($item['children'] as $variant) {


                    $dataProducts[] = [
                        'id' => $variant['id'],  // Giữ ID cha
                        'name' => '--|' . $variant['name'],
                        'quantity' => $variant['quantity'],
                        'sku' => $variant['sku'],
                        'product_variants' => $variant['product_variants'],
                        'price' => $variant['price'],
                        'price_sale' => $variant['price_sale'],
                    ];
                }
            }
        }


        return $dataProducts;
    }

    public static function combineArrays($array)
    {

        $values = array_values($array);


        // Khởi tạo kết quả
        $result = [[]];

        // Duyệt qua từng mảng con
        foreach ($values as $subArray) {
            $newResult = [];
            foreach ($result as $combination) {
                foreach ($subArray as $value) {
                    // Tạo các kết hợp mới
                    $newResult[] = array_merge($combination, [$value]);
                }
            }
            $result = $newResult; // Cập nhật kết quả với các kết hợp mới
        }
        return $result;
    }
}
