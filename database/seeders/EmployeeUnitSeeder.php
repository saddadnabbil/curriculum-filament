<?php

namespace Database\Seeders;

use App\Models\EmployeeUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeUnit::create(['code' => 'E01', 'name' => 'Extracurricular Teacher']);
        EmployeeUnit::create(['code' => 'G01', 'name' => 'Playgroup - Kindergarten']);
        EmployeeUnit::create(['code' => 'G02', 'name' => 'Primary']);
        EmployeeUnit::create(['code' => 'G03', 'name' => 'Junior High School']);
        EmployeeUnit::create(['code' => 'G04', 'name' => 'Senior High School']);
        EmployeeUnit::create(['code' => 'HR1', 'name' => 'HRD']);
        EmployeeUnit::create(['code' => 'K01', 'name' => 'Finance Admin']);
        EmployeeUnit::create(['code' => 'L01', 'name' => 'Librarian']);
        EmployeeUnit::create(['code' => 'M01', 'name' => 'Admission']);
        EmployeeUnit::create(['code' => 'S01', 'name' => 'Security']);
        EmployeeUnit::create(['code' => 'S02', 'name' => 'Suster']);
        EmployeeUnit::create(['code' => 'S03', 'name' => 'Sauber']);
        EmployeeUnit::create(['code' => 'T01', 'name' => 'IT Staff']);
        EmployeeUnit::create(['code' => 'U01', 'name' => 'General Affair']);
        EmployeeUnit::create(['code' => 'U02', 'name' => 'Cleaner']);
    }
}
