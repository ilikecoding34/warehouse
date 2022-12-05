<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //php artisan db:seed --class=RolesAndPermissionsSeeder
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions

        Permission::create(['name' => 'item-list']);
        Permission::create(['name' => 'item-create']);
        Permission::create(['name' => 'item-edit']);
        Permission::create(['name' => 'item-delete']);
        Permission::create(['name' => 'role-list']);
        Permission::create(['name' => 'role-create']);
        Permission::create(['name' => 'role-edit']);
        Permission::create(['name' => 'role-delete']);
        Permission::create(['name' => 'permission-list']);
        Permission::create(['name' => 'permission-create']);
        Permission::create(['name' => 'permission-edit']);
        Permission::create(['name' => 'permission-delete']);
        Permission::create(['name' => 'user-list']);
        Permission::create(['name' => 'user-create']);
        Permission::create(['name' => 'user-edit']);
        Permission::create(['name' => 'user-delete']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'user-handler']);

        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete'
        ];

        $role->syncPermissions($permissions);


        $role = Role::create(['name' => 'item-handler']);
        $role->givePermissionTo(['item-list', 'item-create', 'item-edit', 'item-delete']);

        $role = Role::create(['name' => 'auth-handler']);
        $role->givePermissionTo(['permission-list', 'permission-create', 'permission-edit', 'permission-delete']);

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo(['item-list', 'item-edit']);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

    }
}
