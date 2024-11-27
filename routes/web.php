<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Backend\AI\AIController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Client\DetailController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\PolicyController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\VoucherController;
use App\Http\Controllers\Client\AboutPageController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\IntroduceController;
use App\Http\Controllers\Backend\CategoriesController;
use App\Http\Controllers\Backend\PropertiesController;


use App\Http\Controllers\Backend\TransactionController;
use App\Http\Controllers\Backend\GroupProductController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Backend\OrderController as BackendOrderController;
use App\Http\Controllers\Client\ProfileController as ClientProfileController;

Route::prefix('admin')->middleware(['auth', 'verified', 'is_admin'])->group(function () {
    //ANCHOR - [Ecommerce Modules]
    Route::name('dashboard_module.')->group(function () {

        //LINK - BannerController
        Route::prefix('dashboard')->middleware(['permission:Quản lý trang chủ'])->name('dashboard.')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('index');
            Route::get('/product-sales', [DashboardController::class, 'getSalesData'])->name('getSalesData');
        });
    });

    //ANCHOR - [Account Modules]
    Route::name('account_module.')->group(function () {

        //LINK - UserController
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->middleware(['permission:Quản lý tài khoản'])->name('index');
            Route::get('/getData', [UserController::class, 'getData'])->middleware(['permission:Quản lý tài khoản'])->name('getData');
            Route::get('/create', [UserController::class, 'create'])->middleware(['permission:Thêm mới tài khoản'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->middleware(['permission:Thêm mới tài khoản'])->name('store');
            Route::get('/edit/{user}', [UserController::class, 'edit'])->middleware(['permission:Cập nhật tài khoản'])->name('edit');
            Route::post('/update/{user}', [UserController::class, 'update'])->middleware(['permission:Cập nhật tài khoản'])->name('update');
            Route::post('/toggleStatus', [UserController::class, 'toggleStatus'])->middleware(['permission:Cập nhật tài khoản'])->name('toggleStatus');
            Route::delete('/deleteAll', [UserController::class, 'deleteAll'])->middleware(['permission:Xoá tài khoản'])->name('deleteAll');
            Route::delete('/deleteRow', [UserController::class, 'deleteRow'])->middleware(['permission:Xoá tài khoản'])->name('deleteRow');
            Route::get('/export', [UserController::class, 'export'])->middleware(['permission:Xuất tài khoản'])->name('export');
            Route::post('/import', [UserController::class, 'import'])->middleware(['permission:Xuất tài khoản'])->name('import');
        });

        //LINK - RoleController
        Route::prefix('role')->name('role.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->middleware(['permission:Quản lý phân quyền'])->name('index');
            Route::get('/getData', [RoleController::class, 'getData'])->middleware(['permission:Quản lý phân quyền'])->name('getData');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::post('/store', [RoleController::class, 'store'])->name('store');
            Route::get('/edit/{role}', [RoleController::class, 'edit'])->name('edit');
            Route::delete('/deleteRow', [RoleController::class, 'deleteRow'])->name('deleteRow');
            Route::delete('/deleteAll', [RoleController::class, 'deleteAll'])->name('deleteAll');
        });
    });

    //ANCHOR - [Ecommecre Modules]
    Route::name('ecommerce_module.')->group(function () {

        //LINK - Categories
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [CategoriesController::class, 'index'])->middleware(['permission:Quản lý danh mục'])->name('index');
            Route::get('/getData', [CategoriesController::class, 'getData'])->middleware(['permission:Quản lý danh mục'])->name('getData');
            Route::get('/detaiProductCategories', [CategoriesController::class, 'detaiProductCategories'])->middleware(['permission:Quản lý danh mục'])->name('detaiProductCategories');
            Route::get('/create', [CategoriesController::class, 'create'])->middleware(['permission:Thêm mới danh mục'])->name('create');
            Route::post('/store', [CategoriesController::class, 'store'])->middleware(['permission:Thêm mới danh mục'])->name('store');
            Route::get('/edit/{categories}', [CategoriesController::class, 'edit'])->middleware(['permission:Cập nhật danh mục'])->name('edit');
            Route::post('/update/{categories}', [CategoriesController::class, 'update'])->middleware(['permission:Cập nhật danh mục'])->name('update');
            Route::post('/toggleStatus', [CategoriesController::class, 'toggleStatus'])->middleware(['permission:Cập nhật danh mục'])->name('toggleStatus');
            Route::delete('/deleteAll', [CategoriesController::class, 'deleteAll'])->middleware(['permission:Xoá danh mục'])->name('deleteAll');
            Route::delete('/deleteRow', [CategoriesController::class, 'deleteRow'])->middleware(['permission:Xoá danh mục'])->name('deleteRow');
        });

        //LINK - Banner
        Route::prefix('banner')->name('banner.')->group(function () {
            Route::get('/', [BannerController::class, 'index'])->middleware(['permission:Quản lý banner'])->name('index');
            Route::get('/getData', [BannerController::class, 'getData'])->middleware(['permission:Quản lý banner'])->name('getData');
            Route::get('/create', [BannerController::class, 'create'])->middleware(['permission:Thêm mới banner'])->name('create');
            Route::post('/store', [BannerController::class, 'store'])->middleware(['permission:Thêm mới banner'])->name('store');
            Route::get('/edit/{banner}', [BannerController::class, 'edit'])->middleware(['permission:Cập nhật banner'])->name('edit');
            Route::post('/update/{banner}', [BannerController::class, 'update'])->middleware(['permission:Cập nhật banner'])->name('update');
            Route::post('/toggleStatus', [BannerController::class, 'toggleStatus'])->middleware(['permission:Cập nhật banner'])->name('toggleStatus');
            Route::delete('/deleteAll', [BannerController::class, 'deleteAll'])->middleware(['permission:Xoá banner'])->name('deleteAll');
            Route::delete('/deleteRow', [BannerController::class, 'deleteRow'])->middleware(['permission:Xoá banner'])->name('deleteRow');
        });

        //LINK - Properties
        Route::prefix('properties')->name('properties.')->group(function () {
            Route::get('/', [PropertiesController::class, 'index'])->middleware(['permission:Quản lý thuộc tính'])->name('index');
            Route::get('/getData', [PropertiesController::class, 'getData'])->middleware(['permission:Quản lý thuộc tính'])->name('getData');
            Route::get('/create', [PropertiesController::class, 'create'])->middleware(['permission:Thêm mới thuộc tính'])->name('create');
            Route::post('/store', [PropertiesController::class, 'store'])->middleware(['permission:Thêm mới thuộc tính'])->name('store');
            Route::get('/edit/{properties}', [PropertiesController::class, 'edit'])->middleware(['permission:Cập nhật thuộc tính'])->name('edit');
            Route::post('/update/{properties}', [PropertiesController::class, 'update'])->middleware(['permission:Cập ntật thuộc tính'])->name('update');
            Route::post('/toggleStatus', [PropertiesController::class, 'toggleStatus'])->middleware(['permission:Cập nhật thuộc tính'])->name('toggleStatus');
            Route::delete('/deleteAll', [PropertiesController::class, 'deleteAll'])->middleware(['permission:Xoá thuộc tính'])->name('deleteAll');
            Route::delete('/deleteRow', [PropertiesController::class, 'deleteRow'])->middleware(['permission:Xoá thuộc tính'])->name('deleteRow');
        });

        //LINK - Products
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->middleware(['permission:Quản lý sản phẩm'])->name('index');
            Route::get('/getData', [ProductController::class, 'getData'])->middleware(['permission:Quản lý sản phẩm'])->name('getData');
            Route::get('/create', [ProductController::class, 'create'])->middleware(['permission:Thêm mới sản phẩm'])->name('create');
            Route::post('/store', [ProductController::class, 'store'])->middleware(['permission:Thêm mới sản phẩm'])->name('store');
            Route::get('/edit/{products}', [ProductController::class, 'edit'])->middleware(['permission:Cập nhật sản phẩm'])->name('edit');
            Route::post('/update/{products}', [ProductController::class, 'update'])->middleware(['permission:Cập nhật sản phẩm'])->name('update');
            Route::post('/toggleStatus', [ProductController::class, 'toggleStatus'])->middleware(['permission:Cập nhật sản phẩm'])->name('toggleStatus');
            Route::delete('/deleteAll', [ProductController::class, 'deleteAll'])->middleware(['permission:Xoá sản phẩm'])->name('deleteAll');
            Route::delete('/deleteRow', [ProductController::class, 'deleteRow'])->middleware(['permission:Xoá sản phẩm'])->name('deleteRow');
        });

        //LINK - Brand
        Route::prefix('brand')->name('brand.')->group(function () {
            Route::get('/', [BrandController::class, 'index'])->name('index');
            Route::get('/getData', [BrandController::class, 'getData'])->middleware(['permission:Quản lý sản phẩm'])->name('getData');
            Route::get('/create', [BrandController::class, 'create'])->middleware(['permission:Quản lý sản phẩm'])->name('create');
            Route::post('/store', [BrandController::class, 'store'])->middleware(['permission:Quản lý sản phẩm'])->name('store');
            Route::get('/edit/{brand}', [BrandController::class, 'edit'])->middleware(['permission:Quản lý sản phẩm'])->name('edit');
            Route::post('/update/{brand}', [BrandController::class, 'update'])->middleware(['permission:Quản lý sản phẩm'])->name('update');
            Route::post('/toggleStatus', [BrandController::class, 'toggleStatus'])->middleware(['permission:Quản lý sản phẩm'])->name('toggleStatus');
            Route::delete('/deleteAll', [BrandController::class, 'deleteAll'])->middleware(['permission:Quản lý sản phẩm'])->name('deleteAll');
            Route::delete('/deleteRow', [BrandController::class, 'deleteRow'])->middleware(['permission:Quản lý sản phẩm'])->name('deleteRow');
        });



        //LINK - Transaction
        Route::prefix('transaction')->name('transaction.')->group(function () {
            Route::get('/', [TransactionController::class, 'index'])->middleware(['permission:Quản lý kho'])->name('index');
            Route::get('/getData', [TransactionController::class, 'getData'])->middleware(['permission:Quản lý kho'])->name('getData');
            Route::post('/getTransactionById', [TransactionController::class, 'getTransactionById'])->middleware(['permission:Xuất kho'])->name('getTransactionById');

            Route::get('/exportTransaction', [TransactionController::class, 'exportTransaction'])->middleware(['permission:Xuất kho'])->name('exportTransaction');
        });

        //LINK - Voucher
        Route::prefix('voucher')->name('voucher.')->group(function () {
            Route::get('/', [VoucherController::class, 'index'])->middleware(['permission:Quản lý khuyến mãi'])->name('index');
            Route::get('/getData', [VoucherController::class, 'getData'])->middleware(['permission:Quản lý khuyến mãi'])->name('getData');
            Route::get('/create', [VoucherController::class, 'create'])->middleware(['permission:Thêm mới khuyến mãi'])->name('create');
            Route::post('/store', [VoucherController::class, 'store'])->middleware(['permission:Thêm mới khuyến mãi'])->name('store');
            Route::get('/edit/{voucher}', [VoucherController::class, 'edit'])->middleware(['permission:Cập nhật khuyến mãi'])->name('edit');
            Route::post('/update/{voucher}', [VoucherController::class, 'update'])->middleware(['permission:Cập nhật khuyến mãi'])->name('update');
            Route::post('/toggleStatus', [VoucherController::class, 'toggleStatus'])->middleware(['permission:Cập nhật khuyến mãi'])->name('toggleStatus');
            Route::delete('/deleteAll', [VoucherController::class, 'deleteAll'])->middleware(['permission:Xoá khuyến mãi'])->name('deleteAll');
            Route::delete('/deleteRow', [VoucherController::class, 'deleteRow'])->middleware(['permission:Xoá khuyến mãi'])->name('deleteRow');
        });

        //LINK - GroupProduct
        Route::prefix('groupProduct')->name('groupProduct.')->group(function () {
            Route::get('/', [GroupProductController::class, 'index'])->middleware(['permission:Quản lý nhóm sản phẩm'])->name('index');
            Route::get('/getData', [GroupProductController::class, 'getData'])->middleware(['permission:Quản lý nhóm sản phẩm'])->name('getData');
            Route::get('/create', [GroupProductController::class, 'create'])->middleware(['permission:Thêm mới nhóm sản phẩm'])->name('create');
            Route::post('/store', [GroupProductController::class, 'store'])->middleware(['permission:Thêm mới nhóm sản phẩm'])->name('store');
            Route::get('/edit/{groupProduct}', [GroupProductController::class, 'edit'])->middleware(['permission:Cập nhật nhóm sản phẩm'])->name('edit');
            Route::post('/update/{groupProduct}', [GroupProductController::class, 'update'])->middleware(['permission:Cập nhật nhóm sản phẩm'])->name('update');
            Route::post('/toggleStatus', [GroupProductController::class, 'toggleStatus'])->middleware(['permission:Cập nhật nhóm sản phẩm'])->name('toggleStatus');
            Route::delete('/deleteAll', [GroupProductController::class, 'deleteAll'])->middleware(['permission:Xoá nhóm sản phẩm'])->name('deleteAll');
            Route::delete('/deleteRow', [GroupProductController::class, 'deleteRow'])->middleware(['permission:Xoá nhóm sản phẩm'])->name('deleteRow');
            Route::post('/getAllProducts', [GroupProductController::class, 'getAllProducts'])->name('getAllProducts');
            Route::get('/searchProduct', [GroupProductController::class, 'searchProduct'])->name('searchProduct');
        });


        //LINK - Order
        Route::prefix('order')->name('order.')->group(function () {
            Route::get('/', [BackendOrderController::class, 'index'])->middleware(['permission:Quản lý đơn hàng'])->name('index');
            Route::get('/getData', [BackendOrderController::class, 'getData'])->middleware(['permission:Quản lý đơn hàng'])->name('getData');
            Route::post('/status-order', [BackendOrderController::class, 'statusOrder'])->middleware(['permission:Cập nhật đơn hàng'])->name('statusOrder');
            Route::post('/get-item-order', [BackendOrderController::class, 'getItemOrder'])->middleware(['permission:Xem đơn hàng'])->name('getItemOrder');
            Route::get('/excel-order', [BackendOrderController::class, 'excelOrder'])->middleware(['permission:Xuất đơn hàng'])->name('excelOrder');
        });


        //LINK - Ajax
        Route::prefix('ajax')->name('ajax.')->group(function () {
            Route::post('/getChildrenProperties', [ProductController::class, 'getChildrenProperties'])->name('getChildrenProperties');
            Route::post('/getAttributeAjax', [ProductController::class, 'getAttributeAjax'])->name('getAttributeAjax');
        });
    });

    //ANCHOR - [Settings Modules]
    Route::name('setting_module.')->group(function () {

        //LINK - Settings
        Route::prefix('setting')->name('setting.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->middleware(['permission:Cài đặt chung'])->name('index');
            Route::post('/updateOrCreate', [SettingController::class, 'updateOrCreate'])->middleware(['permission:Cài đặt chung'])->name('updateOrCreate');
        });

        //LINK - Policy
        Route::prefix('policy')->name('policy.')->group(function () {
            Route::get('/', [PolicyController::class, 'index'])->middleware(['permission:Chính sách hỗ trợ'])->name('index');
            Route::get('/getData', [PolicyController::class, 'getData'])->middleware(['permission:Chính sách hỗ trợ'])->name('getData');
            Route::get('/create', [PolicyController::class, 'create'])->middleware(['permission:Chính sách hỗ trợ'])->name('create');
            Route::post('/store', [PolicyController::class, 'store'])->middleware(['permission:Chính sách hỗ trợ'])->name('store');
            Route::get('/edit/{policy}', [PolicyController::class, 'edit'])->middleware(['permission:Chính sách hỗ trợ'])->name('edit');
            Route::post('/update/{policy}', [PolicyController::class, 'update'])->middleware(['permission:Chính sách hỗ trợ'])->name('update');
            Route::post('/toggleStatus', [PolicyController::class, 'toggleStatus'])->middleware(['permission:Chính sách hỗ trợ'])->name('toggleStatus');
            Route::delete('/deleteAll', [PolicyController::class, 'deleteAll'])->middleware(['permission:Chính sách hỗ trợ'])->name('deleteAll');
            Route::delete('/deleteRow', [PolicyController::class, 'deleteRow'])->middleware(['permission:Chính sách hỗ trợ'])->name('deleteRow');
            Route::post('/upload-image', [PolicyController::class, 'uploadImage'])->middleware(['permission:Chính sách hỗ trợ'])->name('uploadImage');
            Route::post('/ai-assistant', [PolicyController::class, 'processContent'])->middleware(['permission:Chính sách hỗ trợ'])->name('processContent');
        });

        //LINK - Contact
        Route::prefix('contact')->name('contact.')->group(function () {
            Route::get('/', [ContactController::class, 'index'])->middleware(['permission:Hỗ trợ và liên hệ'])->name('index');
            Route::get('/getData', [ContactController::class, 'getData'])->middleware(['permission:Hỗ trợ và liên hệ'])->name('getData');
            Route::get('/getMessage', [ContactController::class, 'getMessage'])->middleware(['permission:Hỗ trợ và liên hệ'])->name('getMessage');
            Route::post('/sendMessage', [ContactController::class, 'sendMessage'])->middleware(['permission:Hỗ trợ và liên hệ'])->name('sendMessage');
            Route::post('/toggleStatus', [ContactController::class, 'toggleStatus'])->middleware(['permission:Hỗ trợ và liên hệ'])->name('toggleStatus');
            Route::delete('/deleteAll', [ContactController::class, 'deleteAll'])->middleware(['permission:Hỗ trợ và liên hệ'])->name('deleteAll');
            Route::delete('/deleteRow', [ContactController::class, 'deleteRow'])->middleware(['permission:Hỗ trợ và liên hệ'])->name('deleteRow');
        });

        //LINK - Introduce
        Route::prefix('introduce')->name('introduce.')->group(function () {
            Route::get('/', [IntroduceController::class, 'index'])->middleware(['permission:Giới thiệu'])->name('index');
            Route::post('/upload-image', action: [IntroduceController::class, 'uploadImage'])->name('uploadImage');
            Route::post('/store', action: [IntroduceController::class, 'store'])->middleware(['permission:Giới thiệu'])->name('store');
        });
    });

    //LINK - Voucher
    Route::prefix('ai')->name('ai.')->group(function () {
        Route::post('chat', [AIController::class, 'chat'])->name('chat');
    });
});


Route::get('/', [HomeController::class, 'index'])->name('index');
Route::post('/hotline-ajax', [HomeController::class, 'hotlineAjax'])->name('hotlineAjax');

Route::get('/danh-muc/{slug}/{id}', [DetailController::class, 'detail'])->name('detail');
Route::get('/get-products-ajax', [DetailController::class, 'getProducts'])->name('getProducts');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/search-product-ajax', [HomeController::class, 'searchAjax'])->name('searchAjax');

Route::get('/all-product-categories', [DetailController::class, 'allProductCategories'])->name('allProductCategories');
Route::get('/all-product-categories-ajax', [DetailController::class, 'allProductCategoriesAjax'])->name('allProductCategoriesAjax');

Route::get('/nhom-san-pham/{slug}', [DetailController::class, 'allGroupProduct'])->name('allGroupProduct');
Route::get('/get-group-product-ajax', [DetailController::class, 'getGroupProductAjax'])->name('getGroupProductAjax');

Route::get('/danh-muc-san-pham/{slug}', [DetailController::class, 'getFirstCategories'])->name('getFirstCategories');
Route::get('/danh-muc-san-pham-ajax', [DetailController::class, 'getFirstCategoriesAjax'])->name('getFirstCategoriesAjax');

Route::get('get-attribute-ajax',[DetailController::class,'getAttributeAjax'])->name('getAttributeAjax');

Route::get('/san-pham/{slug}', [DetailController::class, 'firstProduct'])->name('firstProduct');

Route::get('gio-hang', [CartController::class,'index'])->middleware('auth')->name('cart.index');
Route::post('/add-cart', [CartController::class, 'addCart'])->name('addCart');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('updateCart');
Route::post('/delete-cart', [CartController::class, 'deleteCart'])->name('deleteCart');

Route::get('tai-khoan', [ClientProfileController::class, 'showTabs'])->middleware('auth')->name('showTabs');
Route::post('change-password', [ClientProfileController::class,'changePassword'])->name('changePassword');

Route::get('/check-voucher', [CartController::class, 'checkVoucher'])->name('checkVoucher');

Route::post('/order',[OrderController::class,'order'])->name('order');

Route::get('/gioi-thieu', [AboutPageController::class, 'index'])->name('aboutPage');

Route::get('/thank', function () {
    return view('client.page.thank');
});


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//LINK - UploadController
Route::post('/upload', [UploadController::class, 'upload'])->name('upload');
require __DIR__ . '/auth.php';
