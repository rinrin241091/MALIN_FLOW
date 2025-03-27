<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission; 
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    //dùng RABC(Role-Based Accsess Controll) với spatie/laravel-permission
    public function run(): void
    {
        //Tạo quyền quản lý dashboard
        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'add user']);
        Permission::create(['name' => 'view dashboard']);

        Permission::create(['name' => 'view home']);

        //Tạo quyèn quản lý hồ sơ
        Permission::create(['name' => 'view settings']);
        Permission::create(['name' => 'change password']);
        Permission::create(['name' => 'update profile']);
        Permission::create(['name' => 'change language']);
        Permission::create(['name' => 'update privacy']);

        //Tạo vai trò
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);  

        //Gán quyền cho admin
        $adminRole->givePermissionTo([
            'view user',
            'edit user',
            'delete user',
            'add user',
            'view dashboard',
            'view settings',
            'change password',
            'update profile',
            'change language',
            'update privacy'
        ]);

        //Gán quyền cho user
        $userRole->givePermissionTo([
            'view home',
            'view settings',
            'change password',
            'update profile',
            'change language',
            'update privacy'
        ]);

        // Gán vai trò admin cho người dùng đầu tiên (nếu tồn tại)
        $admin = User::find(1); // Người dùng đầu tiên
        if ($admin) {
            $admin->assignRole('admin');
        }
    }
}
