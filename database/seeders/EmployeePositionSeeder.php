<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeePosition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class EmployeePositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeePosition::create(['code' => '000', 'name' => 'CURRICULUM PLAN DEVELOPMENT', 'slug' => Str::slug('CURRICULUM PLAN DEVELOPMENT')]);
        EmployeePosition::create(['code' => '100', 'name' => 'PRINCIPAL', 'slug' => Str::slug('PRINCIPAL')]);
        EmployeePosition::create(['code' => '150', 'name' => 'SENIOR VICE PRINCIPAL', 'slug' => Str::slug('SENIOR VICE PRINCIPAL')]);
        EmployeePosition::create(['code' => '200', 'name' => 'VICE PRINCIPAL STUDENT AFFAIR', 'slug' => Str::slug('VICE PRINCIPAL STUDENT AFFAIR')]);
        EmployeePosition::create(['code' => '300', 'name' => 'HOMEROOM', 'slug' => Str::slug('HOMEROOM')]);
        EmployeePosition::create(['code' => '310', 'name' => 'VICE PRINCIPAL CURRICULUM', 'slug' => Str::slug('VICE PRINCIPAL CURRICULUM')]);
        EmployeePosition::create(['code' => '400', 'name' => 'TEACHER', 'slug' => Str::slug('TEACHER')]);
        EmployeePosition::create(['code' => '410', 'name' => 'EXTRACURRICULAR TEACHER', 'slug' => Str::slug('EXTRACURRICULAR TEACHER')]);
        EmployeePosition::create(['code' => '500', 'name' => 'CLASS ASSISTANT', 'slug' => Str::slug('CLASS ASSISTANT')]);
        EmployeePosition::create(['code' => '900', 'name' => 'ADMIN UNIT', 'slug' => Str::slug('ADMIN UNIT')]);
        EmployeePosition::create(['code' => '901', 'name' => 'REPRESENTATIVE BOARD OF FOUNDATION', 'slug' => Str::slug('REPRESENTATIVE BOARD OF FOUNDATION')]);
        EmployeePosition::create(['code' => '910', 'name' => 'GENERAL AFFAIR', 'slug' => Str::slug('GENERAL AFFAIR')]);
        EmployeePosition::create(['code' => '911', 'name' => 'CLEANER', 'slug' => Str::slug('CLEANER')]);
        EmployeePosition::create(['code' => '920', 'name' => 'NURSE', 'slug' => Str::slug('NURSE')]);
        EmployeePosition::create(['code' => '930', 'name' => 'SECURITY', 'slug' => Str::slug('SECURITY')]);
        EmployeePosition::create(['code' => '940', 'name' => 'CCTV MONITOR', 'slug' => Str::slug('CCTV MONITOR')]);
        EmployeePosition::create(['code' => '950', 'name' => 'COUNSELOR', 'slug' => Str::slug('COUNSELOR')]);
        EmployeePosition::create(['code' => '960', 'name' => 'ADMISSION STAFF', 'slug' => Str::slug('ADMISSION STAFF')]);
        EmployeePosition::create(['code' => '990', 'name' => 'CONTENT CREATOR', 'slug' => Str::slug('CONTENT CREATOR')]);
        EmployeePosition::create(['code' => '991', 'name' => 'PROGRAMMER', 'slug' => Str::slug('PROGRAMMER')]);
        EmployeePosition::create(['code' => '992', 'name' => 'IT SUPPORT', 'slug' => Str::slug('IT SUPPORT')]);
        EmployeePosition::create(['code' => 'CSO', 'name' => 'CUSTOMER SERVICE OFFICER', 'slug' => Str::slug('CUSTOMER SERVICE OFFICER')]);
        EmployeePosition::create(['code' => 'DR1', 'name' => 'DRIVER', 'slug' => Str::slug('DRIVER')]);
        EmployeePosition::create(['code' => 'FNA', 'name' => 'FINANCE ADMIN', 'slug' => Str::slug('FINANCE ADMIN')]);
        EmployeePosition::create(['code' => 'L01', 'name' => 'LIBRARIAN', 'slug' => Str::slug('LIBRARIAN')]);
        EmployeePosition::create(['code' => 'L02', 'name' => 'LAB ASSISTANT', 'slug' => Str::slug('LAB ASSISTANT')]);
        EmployeePosition::create(['code' => 'L03', 'name' => 'LEADER', 'slug' => Str::slug('LEADER')]);
        EmployeePosition::create(['code' => 'WRA', 'name' => 'WAREHOUSE ADMIN', 'slug' => Str::slug('WAREHOUSE ADMIN')]);
    }
}
