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

// Role
Breadcrumbs::for('role', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('account_module.role.index'));
});
// Role > Create
Breadcrumbs::for('roleCreate', function (BreadcrumbTrail $trail) {
    $trail->parent('role');
    $trail->push(config('apps.role.titleCreate'), route('account_module.role.create'));
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



//NOTE - GroupProduct
// GroupProduct
Breadcrumbs::for('groupProduct', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('ecommerce_module.groupProduct.index'));
});

// GroupProduct > Create
Breadcrumbs::for('groupProductCreate', function (BreadcrumbTrail $trail) {
    $trail->parent('groupProduct');
    $trail->push(config('apps.groupProduct.titleCreate'), route('ecommerce_module.groupProduct.create'));
});

// GroupProduct > Update[client]
Breadcrumbs::for('groupProductUpdate', function (BreadcrumbTrail $trail, $groupProduct) {
    $trail->parent('groupProduct');
    $trail->push(config('apps.groupProduct.titleUpdate') . ' [ ' . $groupProduct->name . ' ] ', route('ecommerce_module.groupProduct.edit', $groupProduct));
});

//NOTE - Order
// Order
Breadcrumbs::for('order', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('ecommerce_module.order.index'));
});

// Order > Create
Breadcrumbs::for('orderCreate', function (BreadcrumbTrail $trail) {
    $trail->parent('order');
    $trail->push(config('apps.order.titleCreate'), route('ecommerce_module.order.create'));
});

// Order > Update[order]
Breadcrumbs::for('orderUpdate', function (BreadcrumbTrail $trail, $order) {
    $trail->parent('order');
    $trail->push(config('apps.order.titleUpdate') . ' [ ' . $order->name . ' ] ', route('ecommerce_module.order.edit', $order));
});


// <=============== SETTING MODULES ===============>
//NOTE - Setting
// Setting
Breadcrumbs::for('setting', function (BreadcrumbTrail $trail) {

    $trail->push('Cài đặt thông tin cấu hình hệ thống', route('setting_module.setting.index'));
});


//NOTE - Policy
// GroupProduct
Breadcrumbs::for('policy', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('setting_module.policy.index'));
});

// Policy > Create
Breadcrumbs::for('policyCreate', function (BreadcrumbTrail $trail) {
    $trail->parent('policy');
    $trail->push(config('apps.policy.titleCreate'), route('setting_module.policy.create'));
});

// Policy > Update[policy]
Breadcrumbs::for('policyUpdate', function (BreadcrumbTrail $trail, $policy) {
    $trail->parent('policy');
    $trail->push(config('apps.policy.titleUpdate') . ' [ ' . $policy->name . ' ] ', route('setting_module.policy.edit', $policy));
});

//NOTE - Contact
// GroupProduct
Breadcrumbs::for('contact', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('setting_module.contact.index'));
});

// Contact > Create
Breadcrumbs::for('contactCreate', function (BreadcrumbTrail $trail) {
    $trail->parent('policy');
    $trail->push(config('apps.contact.titleCreate'), route('setting_module.contact.create'));

});

// Contact > Update[contact]
Breadcrumbs::for('contactUpdate', function (BreadcrumbTrail $trail, $contact) {
    $trail->parent('contact');
    $trail->push(config('apps.contact.titleUpdate') . ' [ ' . $contact->name . ' ] ', route('setting_module.contact.edit', $contact));
});

//NOTE - Introduce
// Introduce
Breadcrumbs::for('introduce', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('setting_module.introduce.index'));
});

// Introduce > Create
// Breadcrumbs::for('introduceCreate', function (BreadcrumbTrail $trail) {
//     $trail->parent('introduce');
//     $trail->push(config('apps.introduce.titleCreate'), route('setting_module.introduce.create'));
// });

// // Introduce > Update[introduce]
// Breadcrumbs::for('introduceUpdate', function (BreadcrumbTrail $trail, $introduce) {
//     $trail->parent('introduce');
//     $trail->push(config('apps.introduce.titleUpdate') . ' [ ' . $introduce->name . ' ] ', route('setting_module.introduce.edit', $introduce));
// });
