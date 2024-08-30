<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// User
Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('account_module.user.index'));
});

// User > Create
Breadcrumbs::for('userCreate', function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push(config('apps.user.titleCreate'), route('account_module.user.create'));
});

// User > Update[User]
Breadcrumbs::for('userUpdate', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user');
    $trail->push(config('apps.user.titleUpdate') . ' [ ' . $user->email . ' ] ', route('account_module.user.edit', $user));
});

//NOTE - Categories
// Categories
Breadcrumbs::for('categories', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('ecommerce_module.categories.index'));
});

// Categories > Create
Breadcrumbs::for('categoriesCreate', function (BreadcrumbTrail $trail) {
    $trail->parent('categories');
    $trail->push(config('apps.categories.titleCreate'), route('ecommerce_module.categories.create'));
});

// Categories > Update[Categories]
Breadcrumbs::for('categoriesUpdate', function (BreadcrumbTrail $trail, $categories) {
    $trail->parent('categories');
    $trail->push(config('apps.categories.titleUpdate') . ' [ ' . $categories->name . ' ] ', route('ecommerce_module.categories.edit', $categories));
});

//NOTE - Banner
// Banner
Breadcrumbs::for('banner', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('ecommerce_module.banner.index'));
});

// bannerUpdate > Create
Breadcrumbs::for('bannerCreate', function (BreadcrumbTrail $trail) {
    $trail->parent('banner');
    $trail->push(config('apps.banner.titleCreate'), route('ecommerce_module.banner.create'));
});

// bannerUpdate > Update[bannerUpdate]
Breadcrumbs::for('bannerUpdate', function (BreadcrumbTrail $trail, $banner) {
    $trail->parent('banner');
    $trail->push(config('apps.banner.titleUpdate') . ' [ ' . $banner->name . ' ] ', route('ecommerce_module.banner.edit', $banner));
});

//NOTE - Properties
// Properties
Breadcrumbs::for('properties', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('ecommerce_module.properties.index'));
});

// propertiesUpdate > Create
Breadcrumbs::for('propertiesCreate', function (BreadcrumbTrail $trail) {
    $trail->parent('properties');
    $trail->push(config('apps.properties.titleCreate'), route('ecommerce_module.properties.create'));
});

// propertiesUpdate > Update[properties]
Breadcrumbs::for('propertiesUpdate', function (BreadcrumbTrail $trail, $properties) {
    $trail->parent('properties');
    $trail->push(config('apps.properties.titleUpdate') . ' [ ' . $properties->name . ' ] ', route('ecommerce_module.properties.edit', $properties));
});


//NOTE - Products
// Products
Breadcrumbs::for('products', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('ecommerce_module.products.index'));
});

// productsUpdate > Create
Breadcrumbs::for('productsCreate', function (BreadcrumbTrail $trail) {
    $trail->parent('products');
    $trail->push(config('apps.products.titleCreate'), route('ecommerce_module.products.create'));
});

// productsUpdate > Update[products]
Breadcrumbs::for('productsUpdate', function (BreadcrumbTrail $trail, $products) {
    $trail->parent('products');
    $trail->push(config('apps.products.titleUpdate') . ' [ ' . $products->name . ' ] ', route('ecommerce_module.products.edit', $products));
});

//NOTE - Brand
// Brand
Breadcrumbs::for('brand', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('ecommerce_module.brand.index'));
});

// brandUpdate > Create
Breadcrumbs::for('brandCreate', function (BreadcrumbTrail $trail) {
    $trail->parent('brand');
    $trail->push(config('apps.brand.titleCreate'), route('ecommerce_module.brand.create'));
});

// brandUpdate > Update[brand]
Breadcrumbs::for('brandUpdate', function (BreadcrumbTrail $trail, $brand) {
    $trail->parent('brand');
    $trail->push(config('apps.brand.titleUpdate') . ' [ ' . $brand->name . ' ] ', route('ecommerce_module.brand.edit', $brand));
});

//NOTE - Label
// Label
Breadcrumbs::for('label', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('ecommerce_module.label.index'));
});

// Label > Create
Breadcrumbs::for('labelCreate', function (BreadcrumbTrail $trail) {
    $trail->parent('label');
    $trail->push(config('apps.label.titleCreate'), route('ecommerce_module.label.create'));
});

// Label > Update[label]
Breadcrumbs::for('labelUpdate', function (BreadcrumbTrail $trail, $label) {
    $trail->parent('label');
    $trail->push(config('apps.label.titleUpdate') . ' [ ' . $label->name . ' ] ', route('ecommerce_module.label.edit', $label));
});

//NOTE - Transaction
// Transaction
Breadcrumbs::for('transaction', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('ecommerce_module.transaction.index'));
});

// Transaction > Create
Breadcrumbs::for('transactionCreate', function (BreadcrumbTrail $trail) {
    $trail->parent('transaction');
    $trail->push(config('apps.transaction.titleCreate'), route('ecommerce_module.transaction.create'));
});

// Transaction > Update[transaction]
Breadcrumbs::for('transactionUpdate', function (BreadcrumbTrail $trail, $transaction) {
    $trail->parent('transaction');
    $trail->push(config('apps.transaction.titleUpdate') . ' [ ' . $transaction->name . ' ] ', route('ecommerce_module.transaction.edit', $transaction));
});

//NOTE - Voucher
// Voucher
Breadcrumbs::for('voucher', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('ecommerce_module.voucher.index'));
});

// Voucher > Create
Breadcrumbs::for('voucherCreate', function (BreadcrumbTrail $trail) {
    $trail->parent('voucher');
    $trail->push(config('apps.voucher.titleCreate'), route('ecommerce_module.voucher.create'));
});

// Voucher > Update[voucher]
Breadcrumbs::for('voucherUpdate', function (BreadcrumbTrail $trail, $voucher) {
    $trail->parent('voucher');
    $trail->push(config('apps.voucher.titleUpdate') . ' [ ' . $voucher->name . ' ] ', route('ecommerce_module.voucher.edit', $voucher));
});

//NOTE - Client
// Client
Breadcrumbs::for('client', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('account_module.client.index'));
});

// Client > Create
Breadcrumbs::for('clientCreate', function (BreadcrumbTrail $trail) {
    $trail->parent('client');
    $trail->push(config('apps.client.titleCreate'), route('account_module.client.create'));
});

// Client > Update[client]
Breadcrumbs::for('clientUpdate', function (BreadcrumbTrail $trail, $client) {
    $trail->parent('client');
    $trail->push(config('apps.client.titleUpdate') . ' [ ' . $client->name . ' ] ', route('account_module.client.edit', $client));
});
