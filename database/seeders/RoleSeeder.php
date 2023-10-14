<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'administrator']);
        $role->givePermissionTo(['users_manage', 'create_project', 'create_user', 'subadmin', 'manager_sale','dashboard']);

        $role = Role::create(['name' => '3dcontent_leader']);
        $role->givePermissionTo('create_project', 'create_user','list_user');

        $role = Role::create(['name' => 'create_project']);
        $role->givePermissionTo('create_project');

        $role = Role::create(['name' => 'subadmin']);
        $role->givePermissionTo('create_user','list_user', 'subadmin','dashboard');


        $role = Role::create(['name' => 'sale_project']);
        $role->givePermissionTo('sale_project');

        $role = Role::create(['name' => 'manager_sale']);
        $role->givePermissionTo('manager_sale','list_user');


        $role = Role::create(['name' => 'viewer']);
        $role->givePermissionTo('viewer');

    }
}
