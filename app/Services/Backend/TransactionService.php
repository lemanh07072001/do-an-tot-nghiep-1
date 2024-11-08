<?php


namespace App\Services\Backend;

use Carbon\Carbon;
use App\Models\Banner;
use App\Models\Properties;
use App\Models\ProductVariant;
use App\Helpers\FormatFunction;
use App\Exports\TransactionExport;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TransactionService
{
    public function getData($request)
    {
        $searchInput = $request->searchInput;


        $filer = [];

        $query =  Products::with(['product_variants'])->orderBy('id', 'desc');


        if ($request->has('searchInput') && isset($searchInput)) {
            $query->whereHas('product_variants', function ($subQuery) use ($searchInput) {
                $subQuery->where('name', 'like', '%' . $searchInput . '%');
            })->orWhere('sku', 'like', '%' . $searchInput . '%'); // Tìm kiếm theo SKU
        }


        $getAllProduct = $query->get();
        $data = []; // Khởi tạo mảng dữ liệu đầu ra


        foreach ($getAllProduct as $product) {
            $dataChildren = [];
            $arrayCode = $product->product_variants;


            // Tạo mã kết hợp và lấy biến thể
            foreach ($arrayCode as $code) {

                $productNameVariant = '';
                $codeArray = explode(', ', $code->code);


                foreach ($codeArray as $codeData) {

                    $propose = Properties::where('id', $codeData)->where('status', 0)->first();

                    $productNameVariant .= '-' . $propose->name;

                    $productName = $product->name . $productNameVariant;


                };
                // $variantsProducts = ProductVariant::where('code',$codeString)->get();


                $dataChildren[] = [
                    'id' => $code->id,
                    'name' => $productName,
                    'sku' => $code->sku,
                    'quantity' => $code->quantity,
                    'price'=> $code->price,
                    'price_sale' => $code->price_sale,
                    'product_variants' => $code->quantity - $code->product_variants,
                ];

            }
            $data[] = [
                'id' => $product->id,
                'name' => $product->name,
                'avatar' => $product->avatar ?? '',
                'children' => $dataChildren,

            ];
        }

        $dataArrayProductVariant = FormatFunction::formatDataProductVariantsForDataTable($data);



        return DataTables::of($dataArrayProductVariant)

            ->addColumn('sku', function ($transaction) {

                return FormatFunction::formatVariantProduct($transaction, 'sku');
            })
            ->addColumn('name', function ($transaction) {

                return FormatFunction::formatTitleVariantProduct($transaction);
            })
            ->addColumn('quantity', function ($transaction) {
                return FormatFunction::formatVariantProduct($transaction, 'quantity');
            })
            ->addColumn('product_variants', function ($transaction) {
                return FormatFunction::formatVariantProduct($transaction, 'product_variants');
            })
            ->addColumn('price', function ($transaction) {
                return FormatFunction::formatVariantProduct($transaction, 'price', true, 'đ');
            })
            ->addColumn('price_sale', function ($transaction) {
                return FormatFunction::formatVariantProduct($transaction, 'price_sale', true, 'đ');
            })



            ->rawColumns(['sku', 'name', 'quantity', 'product_variants', 'price', 'price_sale'])
            ->make(true);
    }

    public function getTransactionById($request)
    {
        $id = $request->get('id');

        $getFind = ProductVariant::with(['products', 'product_variants'])->find($id);


        return response()->json($getFind);
    }



    public function exportTransaction($request)
    {
        $id = $request->get('id');

        // Get the current year, date, and month
        $year = Carbon::now()->year;
        $date = Carbon::now()->day;
        $month = Carbon::now()->month;

        // Construct the file name for the exported Excel file
        $fileName = 'export/products/' . $year . '/' . $date . '-' . $month . '-' . time() . '.xlsx';

        // Use the Excel facade to store the exported data in the specified file path
        Excel::store(new TransactionExport($id), $fileName, 'public');

        // Return a JSON response with the URL of the exported Excel file
        return response()->json([
            'file' => Storage::url($fileName)
        ]);
    }
}
