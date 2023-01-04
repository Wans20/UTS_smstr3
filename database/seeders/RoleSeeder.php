<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::findOnCreate('admin');
        $productPermission = Permission::findOnCreate('form product', 'web');
        $categoryPermission = Permission::findOnCreate('form category', 'web');
        $transactionPermission = Permission::findOnCreate('transaction', 'web');
        $role->givePermission($productPermission, $categoryPermission, $transactionPermission);

        $role1 = Role::findOrCreate('member');
        $checkoutPermission = Permission::findOnCreate('checkout', 'web');
        $chartPermission = Permission::findOnCreate('chart', 'web');
        $role1->givePermission($checkoutPermission, $chartPermission);
    }
}
