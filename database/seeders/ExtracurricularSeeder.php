<?php

namespace Database\Seeders;

use App\Models\Extracurricular;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExtracurricularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Extracurricular::create([
            'academic_year_id' => 1,
            'teacher_id' => 2,
            'name' => 'Web Design',
        ]);
    }
}
