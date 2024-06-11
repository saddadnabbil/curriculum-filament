<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\EmployeePosition;
use App\Models\EmployeeUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Employee
            EmployeeStatusSeeder::class,
            EmployeeUnitSeeder::class,
            EmployeePositionSeeder::class,
            // EmployeeSeeder::class

            RolesTableSeeder::class,
            UsersTableSeeder::class,
        ]);

        Artisan::call('shield:generate --all');
    }
}
