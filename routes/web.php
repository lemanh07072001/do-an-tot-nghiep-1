<?php

use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoriesController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\LabelController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\PropertiesController;
use App\Http\Controllers\Backend\TransactionController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
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

        //LINK - Label
        Route::prefix('label')->name('label.')->group(function () {
            Route::get('/', [LabelController::class, 'index'])->name('index');
            Route::get('/getData', [LabelController::class, 'getData'])->name('getData');
            Route::get('/create', [LabelController::class, 'create'])->name('create');
            Route::post('/store', [LabelController::class, 'store'])->name('store');
            Route::get('/edit/{label}', [LabelController::class, 'edit'])->name('edit');
            Route::post('/update/{label}', [LabelController::class, 'update'])->name('update');
            Route::post('/toggleStatus', [LabelController::class, 'toggleStatus'])->name('toggleStatus');
            Route::delete('/deleteAll', [LabelController::class, 'deleteAll'])->name('deleteAll');
            Route::delete('/deleteRow', [LabelController::class, 'deleteRow'])->name('deleteRow');
        });

         //LINK - Transaction
         Route::prefix('transaction')->name('transaction.')->group(function () {
            Route::get('/', [TransactionController::class, 'index'])->name('index');
            Route::get('/getData', [TransactionController::class, 'getData'])->name('getData');
            Route::post('/getTransactionById', [TransactionController::class, 'getTransactionById'])->name('getTransactionById');
            Route::post('/createTransaction', [TransactionController::class, 'createTransaction'])->name('createTransaction');
            Route::get('/exportTransaction', [TransactionController::class, 'exportTransaction'])->name('exportTransaction');
        });


         //LINK - Ajax
         Route::prefix('ajax')->name('ajax.')->group(function () {
              Route::post('/getChildrenProperties', [ProductController::class, 'getChildrenProperties'])->name('getChildrenProperties');
              Route::get('/getAttributeAjax', [ProductController::class, 'getAttributeAjax'])->name('getAttributeAjax');
        });
    });


    //LINK - UploadController
    Route::post('/upload', [UploadController::class, 'upload'])->name('upload');
});
require __DIR__ . '/auth.php';
