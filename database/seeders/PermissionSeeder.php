<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Artisan;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('cache:clear');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'users_manage']);
        Permission::create(['name' => 'create_user']);
        Permission::create(['name' => 'list_user']);
        Permission::create(['name' => 'create_project']);
        Permission::create(['name' => 'sale_project']);
        Permission::create(['name' => 'subadmin']);
        Permission::create(['name' => 'manager_sale']);
        Permission::create(['name' => 'viewer']);
        Permission::create(['name' => 'dashboard']);
    }
}
