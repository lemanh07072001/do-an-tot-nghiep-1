<?php


namespace App\Services\Backend;

use Carbon\Carbon;
use App\Models\Banner;
use App\Models\Properties;
use App\Models\ProductVariant;
use App\Helpers\FormatFunction;
use App\Exports\TransactionExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TransactionService
{
    public function getData($request)
    {
        $searchInput = $request->searchInput;
        $searchParent = $request->searchParent;

        $filer = [];

        $query =  ProductVariant::query();
        $query = $query->with('products');

        if ($request->has('searchInput') && isset($searchInput)) {
            $query->whereHas('products', function ($query) use ($searchInput) {
                $query->where('name', 'like', '%' . $searchInput . '%');
            });
        }

        if (!empty($filer)) {
            $query = $query->where($filer);
        }


        return DataTables::of($query)
            ->addColumn('name', function ($transaction) {
                return FormatFunction::formatTitleCategories($transaction);
            })
            ->addColumn('sku', function ($transaction) {
                return '<span class="font-semibold">' . $transaction->sku . '</span>';
            })
            ->addColumn('name', function ($transaction) {
                return  FormatFunction::formatTitleVariantProduct($transaction);
            })
            ->addColumn('quantity', function ($transaction) {
                return $transaction->quantity;
            })
            ->addColumn('price', function ($transaction) {
                return FormatFunction::formatPriceProduct($transaction->price);
            })

            ->addColumn('action', function ($transaction) {
                return '
                        <a href="#" data-id="'.$transaction->id.'" class="btnEdit inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-400 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-400 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            <svg class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                        </a>

                    ';
            })

            ->rawColumns(['sku', 'name',  'action','price'])
            ->make(true);
    }

    public function getTransactionById($request){
        $id = $request->get('id');

        $getFind = ProductVariant::with('products')->find($id);
        return response()->json($getFind);
    }

    public function createTransaction($request){
        $quantity = $request->get('quantity');
        $price = $request->get('price');
        $id = $request->get('id');

        $data = [
            'quantity' => $quantity,
            'price' => FormatFunction::formatPrice($request->price),
        ];

        $getFind = ProductVariant::with('products')->find($id);

        $dataUpdate = $getFind->update($data);

        if($dataUpdate){
            return response()->json([
                'message' => 'Cập nhật thành công!'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Lỗi hệ thống vui lòng thử lại sau!'
            ], 500);
        }
    }

    public function exportTransaction($request){
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
