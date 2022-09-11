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
        Permission::create(['name' => $addUser]);
        Permission::create(['name' => $editUser]);
        Permission::create(['name' => $deleteUser]);
        Permission::create(['name' => $suspendUser]);

        //Property Permission
        Permission::create(['name' => $approveProperty]);
        Permission::create(['name' => $declineProperty]);

        //Manage Property
        Permission::create(['name' => $addProperty]);
        Permission::create(['name' => $editProperty]);
        Permission::create(['name' => $deleteProperty]);
        Permission::create(['name' => $viewProperty]);

        $admin = 'admin';
        $agent = 'agent';
        $client = 'client';

        Role::create(['name' => $admin])->givePermissionTo(Permission::all());

        Role::create(['name' => $agent])->givePermissionTo([$editProperty, $addProperty, $deleteProperty, $viewProperty]);

        Role::create(['name' => $client])->givePermissionTo([$viewProperty]);
    }
}
