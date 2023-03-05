<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(10)->hasProperties(3)->create();

        $this->call([
            RolesAndPermissionSeeder::class,
            UserSeeder::class,
            PropertySeeder::class
        ]);
    }
}
