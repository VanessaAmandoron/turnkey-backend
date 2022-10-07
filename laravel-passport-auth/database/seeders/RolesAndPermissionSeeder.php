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
        $editUser = 'edit other users';
        $deleteUser = 'delete user';

        $editProfile = 'edit profile';


        //Properties
        $addProperty = 'add property';
        $editProperty = 'edit property';
        $deleteProperty = 'delete property';
        $viewProperty = 'view property';
        $sendContactDetails = 'send contact details';


        //Create permission first.

        //Users Permission
        Permission::create(['name' => $editUser, 'guard_name' => 'api']);
        Permission::create(['name' => $deleteUser, 'guard_name' => 'api']);
        Permission::create(['name' => $editProfile, 'guard_name' => 'api']);


        //Manage Property
        Permission::create(['name' => $addProperty, 'guard_name' => 'api']);
        Permission::create(['name' => $editProperty, 'guard_name' => 'api']);
        Permission::create(['name' => $deleteProperty, 'guard_name' => 'api']);
        Permission::create(['name' => $viewProperty, 'guard_name' => 'api']);
        Permission::create(['name' => $sendContactDetails, 'guard_name' => 'api']);

        $admin = 'admin';
        $agent = 'agent';
        $client = 'client';

        $role = Role::create(['name' => $admin, 'guard_name' => 'api']);
        $role->givePermissionTo(Permission::all());

        Role::create(['name' => $agent, 'guard_name' => 'api'])->givePermissionTo([$editProperty, $editProfile, $addProperty, $deleteProperty, $viewProperty]);

        Role::create(['name' => $client, 'guard_name' => 'api'])->givePermissionTo([$viewProperty, $sendContactDetails, $editProfile]);
    }
}
