<?php

use App\Http\Controllers\Backend\AI\AIController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoriesController;
use App\Http\Controllers\BackEnd\ChatGpt\ChatGptController;
use App\Http\Controllers\Backend\ClientController;
use App\Http\Controllers\Backend\CommentController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\GroupProductController;
use App\Http\Controllers\Backend\LabelController;
use App\Http\Controllers\Backend\PolicyController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\PropertiesController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\TransactionController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\VoucherController;
use App\Http\Controllers\Client\DetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Client\HomeController;


Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    //ANCHOR - [Ecommerce Modules]
    Route::name('dashboard_module.')->group(function () {

        //LINK - BannerController
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('index');
        });
    });

    //ANCHOR - [Account Modules]
    Route::name('account_module.')->group(function () {

        //LINK - UserController
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/getData', [UserController::class, 'getData'])->name('getData');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
            Route::post('/update/{user}', [UserController::class, 'update'])->name('update');
            Route::post('/toggleStatus', [UserController::class, 'toggleStatus'])->name('toggleStatus');
            Route::delete('/deleteAll', [UserController::class, 'deleteAll'])->name('deleteAll');
            Route::delete('/deleteRow', [UserController::class, 'deleteRow'])->name('deleteRow');
            Route::get('/export', [UserController::class, 'export'])->name('export');
            Route::post('/import', [UserController::class, 'import'])->name('import');
        });
    });

    //ANCHOR - [Ecommecre Modules]
    Route::name('ecommerce_module.')->group(function () {

        //LINK - Categories
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [CategoriesController::class, 'index'])->name('index');
            Route::get('/getData', [CategoriesController::class, 'getData'])->name('getData');
            Route::get('/detaiProductCategories', [CategoriesController::class, 'detaiProductCategories'])->name('detaiProductCategories');
            Route::get('/create', [CategoriesController::class, 'create'])->name('create');
            Route::post('/store', [CategoriesController::class, 'store'])->name('store');
            Route::get('/edit/{categories}', [CategoriesController::class, 'edit'])->name('edit');
            Route::post('/update/{categories}', [CategoriesController::class, 'update'])->name('update');
            Route::post('/toggleStatus', [CategoriesController::class, 'toggleStatus'])->name('toggleStatus');
            Route::delete('/deleteAll', [CategoriesController::class, 'deleteAll'])->name('deleteAll');
            Route::delete('/deleteRow', [CategoriesController::class, 'deleteRow'])->name('deleteRow');
        });

        //LINK - Banner
        Route::prefix('banner')->name('banner.')->group(function () {
            Route::get('/', [BannerController::class, 'index'])->name('index');
            Route::get('/getData', [BannerController::class, 'getData'])->name('getData');
            Route::get('/create', [BannerController::class, 'create'])->name('create');
            Route::post('/store', [BannerController::class, 'store'])->name('store');
            Route::get('/edit/{banner}', [BannerController::class, 'edit'])->name('edit');
            Route::post('/update/{banner}', [BannerController::class, 'update'])->name('update');
            Route::post('/toggleStatus', [BannerController::class, 'toggleStatus'])->name('toggleStatus');
            Route::delete('/deleteAll', [BannerController::class, 'deleteAll'])->name('deleteAll');
            Route::delete('/deleteRow', [BannerController::class, 'deleteRow'])->name('deleteRow');
        });

        //LINK - Properties
        Route::prefix('properties')->name('properties.')->group(function () {
            Route::get('/', [PropertiesController::class, 'index'])->name('index');
            Route::get('/getData', [PropertiesController::class, 'getData'])->name('getData');
            Route::get('/create', [PropertiesController::class, 'create'])->name('create');
            Route::post('/store', [PropertiesController::class, 'store'])->name('store');
            Route::get('/edit/{properties}', [PropertiesController::class, 'edit'])->name('edit');
            Route::post('/update/{properties}', [PropertiesController::class, 'update'])->name('update');
            Route::post('/toggleStatus', [PropertiesController::class, 'toggleStatus'])->name('toggleStatus');
            Route::delete('/deleteAll', [PropertiesController::class, 'deleteAll'])->name('deleteAll');
            Route::delete('/deleteRow', [PropertiesController::class, 'deleteRow'])->name('deleteRow');
        });

        //LINK - Products
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/getData', [ProductController::class, 'getData'])->name('getData');
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/store', [ProductController::class, 'store'])->name('store');
            Route::get('/edit/{products}', [ProductController::class, 'edit'])->name('edit');
            Route::post('/update/{products}', [ProductController::class, 'update'])->name('update');
            Route::post('/toggleStatus', [ProductController::class, 'toggleStatus'])->name('toggleStatus');
            Route::delete('/deleteAll', [ProductController::class, 'deleteAll'])->name('deleteAll');
            Route::delete('/deleteRow', [ProductController::class, 'deleteRow'])->name('deleteRow');
        });

        //LINK - Brand
        Route::prefix('brand')->name('brand.')->group(function () {
            Route::get('/', [BrandController::class, 'index'])->name('index');
            Route::get('/getData', [BrandController::class, 'getData'])->name('getData');
            Route::get('/create', [BrandController::class, 'create'])->name('create');
            Route::post('/store', [BrandController::class, 'store'])->name('store');
            Route::get('/edit/{brand}', [BrandController::class, 'edit'])->name('edit');
            Route::post('/update/{brand}', [BrandController::class, 'update'])->name('update');
            Route::post('/toggleStatus', [BrandController::class, 'toggleStatus'])->name('toggleStatus');
            Route::delete('/deleteAll', [BrandController::class, 'deleteAll'])->name('deleteAll');
            Route::delete('/deleteRow', [BrandController::class, 'deleteRow'])->name('deleteRow');
        });



        //LINK - Transaction
        Route::prefix('transaction')->name('transaction.')->group(function () {
            Route::get('/', [TransactionController::class, 'index'])->name('index');
            Route::get('/getData', [TransactionController::class, 'getData'])->name('getData');
            Route::post('/getTransactionById', [TransactionController::class, 'getTransactionById'])->name('getTransactionById');
            Route::post('/createTransaction', [TransactionController::class, 'createTransaction'])->name('createTransaction');
            Route::get('/exportTransaction', [TransactionController::class, 'exportTransaction'])->name('exportTransaction');
        });

        //LINK - Voucher
        Route::prefix('voucher')->name('voucher.')->group(function () {
            Route::get('/', [VoucherController::class, 'index'])->name('index');
            Route::get('/getData', [VoucherController::class, 'getData'])->name('getData');
            Route::get('/create', [VoucherController::class, 'create'])->name('create');
            Route::post('/store', [VoucherController::class, 'store'])->name('store');
            Route::get('/edit/{voucher}', [VoucherController::class, 'edit'])->name('edit');
            Route::post('/update/{voucher}', [VoucherController::class, 'update'])->name('update');
            Route::post('/toggleStatus', [VoucherController::class, 'toggleStatus'])->name('toggleStatus');
            Route::delete('/deleteAll', [VoucherController::class, 'deleteAll'])->name('deleteAll');
            Route::delete('/deleteRow', [VoucherController::class, 'deleteRow'])->name('deleteRow');
        });

        //LINK - GroupProduct
        Route::prefix('groupProduct')->name('groupProduct.')->group(function () {
            Route::get('/', [GroupProductController::class, 'index'])->name('index');
            Route::get('/getData', [GroupProductController::class, 'getData'])->name('getData');
            Route::get('/create', [GroupProductController::class, 'create'])->name('create');
            Route::post('/store', [GroupProductController::class, 'store'])->name('store');
            Route::get('/edit/{groupProduct}', [GroupProductController::class, 'edit'])->name('edit');
            Route::post('/update/{groupProduct}', [GroupProductController::class, 'update'])->name('update');
            Route::post('/toggleStatus', [GroupProductController::class, 'toggleStatus'])->name('toggleStatus');
            Route::delete('/deleteAll', [GroupProductController::class, 'deleteAll'])->name('deleteAll');
            Route::delete('/deleteRow', [GroupProductController::class, 'deleteRow'])->name('deleteRow');
            Route::post('/getAllProducts', [GroupProductController::class, 'getAllProducts'])->name('getAllProducts');
            Route::get('/searchProduct', [GroupProductController::class, 'searchProduct'])->name('searchProduct');
        });



        //LINK - Ajax
        Route::prefix('ajax')->name('ajax.')->group(function () {
            Route::post('/getChildrenProperties', [ProductController::class, 'getChildrenProperties'])->name('getChildrenProperties');
            Route::get('/getAttributeAjax', [ProductController::class, 'getAttributeAjax'])->name('getAttributeAjax');
        });
    });

    //ANCHOR - [Settings Modules]
    Route::name('setting_module.')->group(function () {

        //LINK - Settings
        Route::prefix('setting')->name('setting.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::post('/updateOrCreate', [SettingController::class, 'updateOrCreate'])->name('updateOrCreate');
        });

        //LINK - Policy
        Route::prefix('policy')->name('policy.')->group(function () {
            Route::get('/', [PolicyController::class, 'index'])->name('index');
            Route::get('/getData', [PolicyController::class, 'getData'])->name('getData');
            Route::get('/create', [PolicyController::class, 'create'])->name('create');
            Route::post('/store', [PolicyController::class, 'store'])->name('store');
            Route::get('/edit/{policy}', [PolicyController::class, 'edit'])->name('edit');
            Route::post('/update/{policy}', [PolicyController::class, 'update'])->name('update');
            Route::post('/toggleStatus', [PolicyController::class, 'toggleStatus'])->name('toggleStatus');
            Route::delete('/deleteAll', [PolicyController::class, 'deleteAll'])->name('deleteAll');
            Route::delete('/deleteRow', [PolicyController::class, 'deleteRow'])->name('deleteRow');
            Route::post('/upload-image', [PolicyController::class, 'uploadImage'])->name('uploadImage');
            Route::post('/ai-assistant', [PolicyController::class, 'processContent'])->name('processContent');
        });

        //LINK - Contact
        Route::prefix('contact')->name('contact.')->group(function () {
            Route::get('/', [ContactController::class, 'index'])->name('index');
            Route::get('/getData', [ContactController::class, 'getData'])->name('getData');
            Route::get('/getMessage', [ContactController::class, 'getMessage'])->name('getMessage');
            Route::post('/sendMessage', [ContactController::class, 'sendMessage'])->name('sendMessage');
            Route::post('/toggleStatus', [ContactController::class, 'toggleStatus'])->name('toggleStatus');
            Route::delete('/deleteAll', [ContactController::class, 'deleteAll'])->name('deleteAll');
            Route::delete('/deleteRow', [ContactController::class, 'deleteRow'])->name('deleteRow');
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
//LINK - UploadController
Route::post('/upload', [UploadController::class, 'upload'])->name('upload');
require __DIR__ . '/auth.php';
