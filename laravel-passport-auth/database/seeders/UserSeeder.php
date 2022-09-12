<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(1)
        ->create(['password' => Hash::make('Default123')])
        ->each(function ($user){
            $user->assignRole('admin');
        }
    );

    // User::factory()->count(2)
    //     ->create()
    //     ->each(function ($user){
    //         $user->assignRole('agent');
    //     }
    // );

    // User::factory()->count(3)
    //     ->create()
    //     ->each(function ($user){
    //         $user->assignRole('client');
    //     }
    // );
    }
}
