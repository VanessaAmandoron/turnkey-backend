<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cached roles and permissions 
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        //Users 
        $addUser = 'add user';
        $editUser = 'edit user';
        $suspendUser = 'suspend user';
        $deleteUser = 'delete user';

        //decline or approve property
        $approveProperty = 'approve property';
        $declineProperty = 'decline property';

        //Properties
        $addProperty = 'add property';
        $editProperty = 'edit property';
        $deleteProperty = 'delete property';
        $viewProperty = 'view property';
        $reserveProperty = 'reserve property';
        $rentProperty = 'rent property';

        //Create permission first.

        //Users Permission
        Permission::create(['name' => $addUser,'guard_name' => 'api']);
        Permission::create(['name' => $editUser,'guard_name' => 'api']);
        Permission::create(['name' => $deleteUser,'guard_name' => 'api']);
        Permission::create(['name' => $suspendUser,'guard_name' => 'api']);

        //Property Permission
        Permission::create(['name' => $approveProperty,'guard_name' => 'api']);
        Permission::create(['name' => $declineProperty,'guard_name' => 'api']);

        //Manage Property
        Permission::create(['name' => $addProperty,'guard_name' => 'api']);
        Permission::create(['name' => $editProperty,'guard_name' => 'api']);
        Permission::create(['name' => $deleteProperty,'guard_name' => 'api']);
        Permission::create(['name' => $viewProperty,'guard_name' => 'api']);
        Permission::create(['name' => $reserveProperty,'guard_name' => 'api']);
        Permission::create(['name' => $rentProperty,'guard_name' => 'api']);

        $admin = 'admin';
        $agent = 'agent';
        $client = 'client';

        $role = Role::create(['name' => $admin, 'guard_name' => 'api']);
        $role->givePermissionTo(Permission::all());

        Role::create(['name' => $agent, 'guard_name' => 'api'])->givePermissionTo([$editProperty, $addProperty, $deleteProperty, $viewProperty]);

        Role::create(['name' => $client, 'guard_name' => 'api'])->givePermissionTo([$viewProperty, $reserveProperty, $rentProperty]);
    }
}
