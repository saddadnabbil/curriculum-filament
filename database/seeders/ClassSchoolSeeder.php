<?php

namespace Database\Seeders;

use App\Models\ClassSchool;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data for PG
        ClassSchool::create([
            'level_id' => 1,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'PG',
        ]);

        // Seed data for KG
        ClassSchool::create([
            'level_id' => 2,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'KG-A1',
        ]);

        ClassSchool::create([
            'level_id' => 2,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'KG-A2',
        ]);

        ClassSchool::create([
            'level_id' => 2,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'KG-A3',
        ]);

        ClassSchool::create([
            'level_id' => 3,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'KG-B1',
        ]);

        ClassSchool::create([
            'level_id' => 3,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'KG-B2',
        ]);

        ClassSchool::create([
            'level_id' => 3,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'KG-B3',
        ]);

        // Seed data for P
        ClassSchool::create([
            'level_id' => 4,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 2,
            'name' => 'P-1A',
        ]);

        ClassSchool::create([
            'level_id' => 4,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'P-1B',
        ]);

        ClassSchool::create([
            'level_id' => 4,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'P-1C',
        ]);

        ClassSchool::create([
            'level_id' => 4,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'P-2A',
        ]);

        ClassSchool::create([
            'level_id' => 4,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'P-2B',
        ]);

        ClassSchool::create([
            'level_id' => 4,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'P-3A',
        ]);

        ClassSchool::create([
            'level_id' => 4,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'P-3B',
        ]);

        ClassSchool::create([
            'level_id' => 4,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'P-4A',
        ]);

        ClassSchool::create([
            'level_id' => 4,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'P-4B',
        ]);

        ClassSchool::create([
            'level_id' => 4,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'P-5A',
        ]);

        ClassSchool::create([
            'level_id' => 4,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'P-6A',
        ]);
        // Seed data for JHS
        ClassSchool::create([
            'level_id' => 5,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'JHS-7A',
        ]);

        ClassSchool::create([
            'level_id' => 5,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'JHS-7B',
        ]);

        ClassSchool::create([
            'level_id' => 5,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'JHS-8A',
        ]);

        ClassSchool::create([
            'level_id' => 5,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'JHS-8B',
        ]);

        ClassSchool::create([
            'level_id' => 5,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'JHS-9A',
        ]);

        ClassSchool::create([
            'level_id' => 5,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'JHS-9B',
        ]);

        // Seed data for SHS
        ClassSchool::create([
            'level_id' => 6,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'SHS-10A',
        ]);

        ClassSchool::create([
            'level_id' => 6,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'SHS-10B',
        ]);

        ClassSchool::create([
            'level_id' => 6,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'SHS-11A',
        ]);

        ClassSchool::create([
            'level_id' => 6,
            'line_id' => 3,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'SHS-11B',
        ]);

        ClassSchool::create([
            'level_id' => 6,
            'line_id' => 1,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'SHS-12IPA',
        ]);

        ClassSchool::create([
            'level_id' => 6,
            'line_id' => 2,
            'academic_year_id' => 1,
            'teacher_id' => 1,
            'name' => 'SHS-12IPS',
        ]);
    }
}
