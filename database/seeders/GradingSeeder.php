<?php

namespace Database\Seeders;

use App\Models\Grading;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GradingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Grading::create([
            'semester_id' => 1,
            'term_id' => 1,
            'member_class_school_id' => 1,
            'plan_formatif_value_id' => '1',
            'plan_sumatif_value_id' => '1',
        ]);

        Grading::create([
            'semester_id' => 1,
            'term_id' => 1,
            'member_class_school_id' => 2,
            'plan_formatif_value_id' => '1',
            'plan_sumatif_value_id' => '1',
        ]);
    }
}
