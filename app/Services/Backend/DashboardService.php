<?php


namespace App\Services\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Banner;
use App\Models\Products;
use App\Models\OrderItem;
use App\Models\Properties;
use App\Helpers\FormatFunction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardService
{
    public function getTopProductsByDays($request)
    {


        function getTopProducts($startDate, $endDate = null, $limit = 5)
        {
            $query = OrderItem::select('product_variant_id', DB::raw('SUM(quantity) as total_quantity'))
                ->whereHas('order', function ($query) use ($startDate, $endDate) {
                    if ($endDate) {
                        $query->whereBetween('created_at', [$startDate, $endDate]);
                    } else {
                        $query->where('created_at', '>=', $startDate);
                    }
                })
                ->groupBy('product_variant_id')
                ->orderByDesc('total_quantity')
                ->with('product_variant.products') // lấy sản phẩm chính của variant
                ->limit($limit)
                ->get();

            // Tính tổng số lượng bán ra trong khoảng thời gian
            $totalQuantity = $query->sum('total_quantity');

            // Tính phần trăm cho từng sản phẩm và truy vấn `properties` dựa trên `code`
            return $query->map(function ($item) use ($totalQuantity) {
                $item->percentage = $totalQuantity ? ($item->total_quantity / $totalQuantity) * 100 : 0;

                $getParentProperties = Properties::whereNull('parent_id')->get();

                // Giả sử product_variant có cột `code`, lấy `properties` theo `code`
                $productVariantCode = $item->product_variant->code;

                // Truy vấn `properties` theo danh sách các `id` từ `productVariantCode`
                $properties = Properties::whereIn('id', explode(', ', $productVariantCode))->get();

                $dataProperties = [];

                // Ghép tên `properties` thành một chuỗi
                foreach ($getParentProperties as $property) {
                    $propertyValues = []; // Mảng chứa các giá trị của thuộc tính

                    foreach ($properties as $value) {
                        // Kiểm tra nếu thuộc tính này có cùng tên với property
                        if ($value->parent_id === $property->id) {
                            // Thêm giá trị của thuộc tính vào mảng `propertyValues`
                            $propertyValues[] = $value->name;
                        }
                    }

                    // Nếu có giá trị cho thuộc tính này, ghép chúng lại thành chuỗi
                    if (!empty($propertyValues)) {
                        $dataProperties[$property->name] = implode(', ', $propertyValues); // Ghép các giá trị với dấu phẩy
                    }
                }


                // Gán tên `properties` vào item
                $item->property_names = $dataProperties;

                return $item;
            });
        }

        // Mốc thời gian
        $todayStart = Carbon::today();
        $todayEnd = Carbon::today()->endOfDay();
        $dayBeforeYesterdayStart = Carbon::yesterday()->subDay();
        $dayBeforeYesterdayEnd = Carbon::yesterday()->endOfDay();
        $sevenDaysAgoStart = Carbon::now()->subDays(7);
        $thirtyDaysAgoStart = Carbon::now()->subDays(30);
        $nintyDaysAgoStart = Carbon::now()->subDays(90);

        // Lấy top sản phẩm bán chạy cho từng mốc thời gian
        $topProductsToday = getTopProducts($todayStart, $todayEnd);
        $topProductsDayBeforeYesterday = getTopProducts($dayBeforeYesterdayStart, $dayBeforeYesterdayEnd);
        $topProductsSevenDays = getTopProducts($sevenDaysAgoStart);
        $topProductsThirtyDays = getTopProducts($thirtyDaysAgoStart);
        $topProductsNintyDays = getTopProducts($nintyDaysAgoStart);

        // Xử lý kết quả dựa trên đầu vào `$last`
        $last = request()->input('last', 'today');
        switch ($last) {
            case 'yesterday':
                $topProducts = $topProductsDayBeforeYesterday;
                break;
            case 'today':
                $topProducts = $topProductsToday;
                break;
            case '7_days':
                $topProducts = $topProductsSevenDays;
                break;
            case '30_days':
                $topProducts = $topProductsThirtyDays;
                break;
            case '90_days':
                $topProducts = $topProductsNintyDays;
                break;
            default:
                $topProducts = $topProductsToday;
                break;
        }

        return $topProducts;
    }

    public function monthNames(){
        $monthNames = [
            1 => 'Tháng 1',
            2 => 'Tháng 2',
            3 => 'Tháng 3',
            4 => 'Tháng 4',
            5 => 'Tháng 5',
            6 => 'Tháng 6',
            7 => 'Tháng 7',
            8 => 'Tháng 8',
            9 => 'Tháng 9',
            10 => 'Tháng 10',
            11 => 'Tháng 11',
            12 => 'Tháng 12'
        ];

        return $monthNames;
    }

    public function getSalesData()
    {
        $data = Products::select(
            DB::raw('YEAR(products.created_at) as year'),
            DB::raw('MONTH(products.created_at) as month'),
            DB::raw('COUNT(products.id) as total_quantity'),
            DB::raw('SUM(product_variants.quantity - product_variants.product_variants) as sold_quantity') // Số sản phẩm đã bán
        )
            ->join('product_variants', 'products.id', '=', 'product_variants.products_id') // Kết nối bảng product_variants
            ->groupBy(DB::raw('YEAR(products.created_at)'), DB::raw('MONTH(products.created_at)'))
            ->orderByRaw('YEAR(products.created_at), MONTH(products.created_at)')
            ->get();

        // Mảng chứa tên các tháng

        $monthNames = $this->monthNames();

        // Tạo mảng kết quả với số lượng cho mỗi tháng và tháng trước đó, bao gồm cả năm
        $result = collect($monthNames)->map(function ($monthName, $month) use ($data, $monthNames) {
            // Lấy năm hiện tại và tính toán tháng trước
            $currentYear = now()->year;  // Hoặc bạn có thể thay đổi năm theo nhu cầu
            $previousYear = $currentYear - 1;

            // Lọc dữ liệu cho tháng hiện tại và tháng trước đó
            $monthData = $data->firstWhere(function ($item) use ($month, $currentYear) {
                return $item->month == $month && $item->year == $currentYear;
            });
            $previousMonthData = $data->firstWhere(function ($item) use ($month, $previousYear) {
                return $item->month == $month && $item->year == $previousYear;
            });

            return [
                'month' => $monthNames[$month],  // Hiển thị tháng dưới dạng "Tháng X"
                'year' => $currentYear,  // Thêm năm vào kết quả
                'quantity' => $monthData ? $monthData->total_quantity : 0,  // Lấy số lượng từ dữ liệu
                'sold_quantity' => $monthData ? $monthData->sold_quantity : 0, // Số sản phẩm đã bán
                'previous_year_quantity' => $previousMonthData ? $previousMonthData->total_quantity : 0,  // Số lượng tháng trước
                'previous_year_sold_quantity' => $previousMonthData ? $previousMonthData->sold_quantity : 0,  // Số sản phẩm đã bán tháng trước
            ];
        });



        $chart = (new LarapexChart)->setType('area')
            ->setTitle('Thống kê sản phẩm thêm thêm và đã bán')
            ->setSubtitle('Trong vòng 12 tháng')
            ->setXAxis($result->pluck('month')->toArray())
            ->setDataset([
                [
                    'name'  =>  'Sản phẩm thêm vào',
                    'data'  =>   $result->pluck('quantity')->toArray()
                ],
            [
                'name'  =>  'Sản phẩm bán ra',
                'data'  =>   $result->pluck('sold_quantity')->toArray()
            ]
            ]);
        return $chart;
    }

    public function getUserData()
    {
        // Lấy dữ liệu từ bảng User
        $data = User::select(
            DB::raw('YEAR(created_at) as year'),  // Thêm năm
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as quantity')
        )
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderByRaw('YEAR(created_at), MONTH(created_at)')  // Sắp xếp theo năm và tháng
            ->get();

        // Mảng chứa tên các tháng
        $monthNames = $this->monthNames();

        // Tạo mảng kết quả với số lượng cho mỗi tháng và tháng trước đó, bao gồm cả năm
        $result = collect($monthNames)->map(function ($monthName, $month) use ($data, $monthNames) {
            // Lấy năm hiện tại và tính toán tháng trước
            $currentYear = now()->year;  // Năm hiện tại
            $previousYear = $currentYear - 1;  // Năm trước

            // Lọc dữ liệu cho tháng hiện tại và tháng trước đó
            $monthData = $data->firstWhere(function ($item) use ($month, $currentYear) {
                return $item->month == $month && $item->year == $currentYear;
            });
            $previousMonthData = $data->firstWhere(function ($item) use ($month, $previousYear) {
                return $item->month == $month && $item->year == $previousYear;
            });

            // Trả về dữ liệu cho tháng hiện tại và tháng trước
            return [
                'month' => $monthNames[$month],  // Hiển thị tháng dưới dạng "Tháng X"
                'year' => $currentYear,  // Thêm năm vào kết quả
                'quantity' => $monthData ? $monthData->quantity : 0,  // Số lượng người dùng trong tháng hiện tại
                'previous_year_quantity' => $previousMonthData ? $previousMonthData->quantity : 0,  // Số lượng người dùng trong tháng trước đó
            ];
        });

        $chart = (new LarapexChart)->setType('area')
            ->setTitle('Thống kê người dùng đã đăng ký')
            ->setSubtitle('Trong vòng 12 tháng')
            ->setXAxis($result->pluck('month')->toArray())
            ->setDataset([
                [
                    'name'  =>  'Người dùng',
                    'data'  =>   $result->pluck('quantity')->toArray()
                ]
            ]);
        return $chart;
    }

    public function getChartData($request){
        $url = $request->get('chart','today');

        // Tạo biểu đồ
        $chart = new LarapexChart;

        $salesData = $this->getData($url);



        // Lấy nhãn cho biểu đồ từ hàm getLabels
        $labels = $this->getLabels($url);


        $chart->setType('area')
            ->setTitle('Thống kế số tiền đã bán sản phẩm')
            ->setSubtitle('Trong vòng 12 tháng')
            ->setXAxis($labels) // Sử dụng nhãn lấy từ getLabels
            ->setDataset([
                [
                    'name' => 'Số tiền',
                    'data' => array_values($salesData['sales']) // Chuyển kết quả từ mảng liên kết sang mảng giá trị
                ]
            ]);

        $data = [
            'chart' => $chart,
            'total' => $salesData['totalSales']
        ];
        return $data;
    }

    private function getData($timeFrame)
    {
        // Lấy dữ liệu bán hàng theo khoảng thời gian
        $query = Order::selectRaw('SUM(total_amount) as total, DATE(created_at) as date')
        ->groupBy('date');

        switch ($timeFrame) {
            case '7_days':
                $query->where('created_at', '>=', now()->subDays(7));
                break;
            case '30_days':
                $query->where('created_at', '>=', now()->subDays(30));
                break;
            case '12_months':
                $query->where('created_at', '>=', now()->subMonths(12));
                break;
            case 'yesterday':
                $query->whereDate('created_at', now()->subDay()->toDateString());
                break;
            default:
                $query->where('created_at', '>=', now()->startOfDay()); // Hôm nay
                break;
        }

        $sales = $query->pluck('total', 'date')->toArray();

        $totalSales = array_sum($sales);

        // Định dạng số tiền theo VND (11.722.000)
        foreach ($sales as $date => $amount) {
            // Check if the amount is greater than zero and format it accordingly
            $sales[$date] = number_format($amount, 0, '.', '.'); // Ensure no decimal places and use dots as thousands separator
        }

        return [
            'sales' => $sales,         // Individual sales amounts by date
            'totalSales' => number_format($totalSales, 0, '.', '.') // Total sales formatted
        ];
    }

    private function getLabels($timeFrame)
    {
        $labels = []; // Mảng để chứa các nhãn của biểu đồ.

        switch ($timeFrame) {
            case '7_days':
                // Nếu là 7 ngày, lấy tất cả các ngày trong 7 ngày qua.
                $labels = iterator_to_array(now()->subDays(7)->daysUntil(now())->map(function ($date) {
                    return $date->format('d/m'); // Định dạng ngày là "ngày/tháng"
                }));
                break;
            case '30_days':
                // Nếu là 30 ngày, lấy tất cả các ngày trong 30 ngày qua.
                $labels = iterator_to_array(now()->subDays(30)->daysUntil(now())->map(function ($date) {
                    return $date->format('d/m'); // Định dạng ngày là "ngày/tháng"
                }));
                break;
            case '12_months':
                // Nếu là 12 tháng, lấy tất cả các tháng trong 12 tháng qua.
                $labels = iterator_to_array(now()->subMonths(12)->monthsUntil(now())->map(function ($date) {
                    return $date->format('m/Y'); // Định dạng là "tháng/năm"
                }));
                break;
            case 'yesterday':
                // Nếu là ngày hôm qua, chỉ lấy một nhãn duy nhất.
                $labels = [now()->subDay()->format('d/m')]; // Định dạng ngày hôm qua là "ngày/tháng"
                break;
            default:
                // Nếu không chọn khoảng thời gian nào, mặc định là ngày hôm nay.
                $labels = [now()->format('d/m')]; // Định dạng ngày là "ngày/tháng"
                break;
        }

        return $labels; // Trả về mảng các nhãn đã được tạo.
    }

    public function getTotalDashboard(){
        $orders = Order::select('status', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as total_amount'))
        ->whereIn('status', ['pending', 'completed', 'cancelled'])
        ->groupBy('status')
        ->get();
        return $orders;
    }

}


