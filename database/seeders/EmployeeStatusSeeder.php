<?php

namespace Database\Seeders;

use App\Models\EmployeeStatus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeStatus::create([
            'code' => '001',
            'name' => 'Karyawan Tetap'
        ]);

        EmployeeStatus::create([
            'code' => '002',
            'name' => 'Karyawan Kontrak'
        ]);

        EmployeeStatus::create([
            'code' => '003',
            'name' => 'Karyawan Outsource'
        ]);

        EmployeeStatus::create([
            'code' => '004',
            'name' => 'Karyawan Part Time'
        ]);
    }
}
