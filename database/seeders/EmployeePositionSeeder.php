<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeePosition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeePositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeePosition::create(['code' => '000', 'name' => 'CURRICULUM PLAN DEVELOPMENT']);
        EmployeePosition::create(['code' => '100', 'name' => 'PRINCIPAL']);
        EmployeePosition::create(['code' => '150', 'name' => 'SENIOR VICE PRINCIPAL']);
        EmployeePosition::create(['code' => '200', 'name' => 'VICE PRINCIPAL STUDENT AFFAIR']);
        EmployeePosition::create(['code' => '300', 'name' => 'HOMEROOM']);
        EmployeePosition::create(['code' => '310', 'name' => 'VICE PRINCIPAL CURRICULUM']);
        EmployeePosition::create(['code' => '400', 'name' => 'TEACHER']);
        EmployeePosition::create(['code' => '410', 'name' => 'EXTRACURRICULAR TEACHER']);
        EmployeePosition::create(['code' => '500', 'name' => 'CLASS ASSISTANT']);
        EmployeePosition::create(['code' => '900', 'name' => 'ADMIN UNIT']);
        EmployeePosition::create(['code' => '901', 'name' => 'REPRESENTATIVE BOARD OF FOUNDATION']);
        EmployeePosition::create(['code' => '910', 'name' => 'GENERAL AFFAIR']);
        EmployeePosition::create(['code' => '911', 'name' => 'CLEANER']);
        EmployeePosition::create(['code' => '920', 'name' => 'NURSE']);
        EmployeePosition::create(['code' => '930', 'name' => 'SECURITY']);
        EmployeePosition::create(['code' => '940', 'name' => 'CCTV MONITOR']);
        EmployeePosition::create(['code' => '950', 'name' => 'COUNSELOR']);
        EmployeePosition::create(['code' => '960', 'name' => 'ADMISSION STAFF']);
        EmployeePosition::create(['code' => '990', 'name' => 'CONTENT CREATOR']);
        EmployeePosition::create(['code' => '991', 'name' => 'PROGRAMMER']);
        EmployeePosition::create(['code' => '992', 'name' => 'IT SUPPORT']);
        EmployeePosition::create(['code' => 'CSO', 'name' => 'CUSTOMER SERVICE OFFICER']);
        EmployeePosition::create(['code' => 'DR1', 'name' => 'DRIVER']);
        EmployeePosition::create(['code' => 'FNA', 'name' => 'FINANCE ADMIN']);
        EmployeePosition::create(['code' => 'L01', 'name' => 'LIBRARIAN']);
        EmployeePosition::create(['code' => 'L02', 'name' => 'LAB ASSISTANT']);
        EmployeePosition::create(['code' => 'L03', 'name' => 'LEADER']);
        EmployeePosition::create(['code' => 'WRA', 'name' => 'WAREHOUSE ADMIN']);
    }
}
