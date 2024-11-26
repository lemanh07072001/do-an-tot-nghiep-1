<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo Role Admin
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // Danh sách Permissions
        $dataPermissions = [
            'Quản lý trang chủ',
            'Quản lý tài khoản',
            'Thêm mới tài khoản',
            'Cập nhật tài khoản',
            'Xoá tài khoản',
            'Xuất tài khoản',

            'Quản lý phân quyền',
            'Thêm mới phân quyền',
            'Cập nhật phân quyền',
            'Xoá phân quyền',

            'Quản lý danh mục',
            'Thêm mới danh mục',
            'Cập nhật danh mục',
            'Xoá danh mục',

            'Quản lý banner',
            'Thêm mới banner',
            'Cập nhật banner',
            'Xoá banner',

            'Quản lý thuộc tính',
            'Thêm mới thuộc tính',
            'Cập nhật thuộc tính',
            'Xoá thuộc tính',

            'Quản lý sản phẩm',
            'Thêm mới sản phẩm',
            'Cập nhật sản phẩm',
            'Xoá sản phẩm',

            'Quản lý kho',
            'Xuất kho',

            'Quản lý khuyến mãi',
            'Thêm mới khuyến mãi',
            'Cập nhật khuyến mãi',
            'Xoá khuyến mãi',
            'Xuất khuyến mãi',

            'Quản lý nhóm sản phẩm',
            'Thêm mới nhóm sản phẩm',
            'Cập nhật nhóm sản phẩm',
            'Xoá nhóm sản phẩm',

            'Quản lý đơn hàng',
            'Xuất đơn hàng',
            'Xem đơn hàng',

            'Cài đặt chung',

            'Chính sách hỗ trợ',

            'Hỗ trợ và liên hệ',

            'Giới thiệu',
        ];

        // Tạo Permissions và gán cho Role Admin
        foreach ($dataPermissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $adminRole->givePermissionTo($permission);
        }

    }
}
