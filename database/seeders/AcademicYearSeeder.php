<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcademicYear::create([
            'year' => '2023-2024',
            'semester_id' => 1,
            'term_id' => 1,
            'status' => 1
        ]);

        AcademicYear::create([
            'year' => '2024-2025',
            'semester_id' => 1,
            'term_id' => 1,
            'status' => 0
        ]);
    }
}
