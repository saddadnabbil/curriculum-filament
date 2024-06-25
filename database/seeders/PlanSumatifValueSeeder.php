<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlanSumatifValue;
use App\Models\PlanSumatifValueTechnique;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlanSumatifValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlanSumatifValue::create([
            'learning_data_id' => 1,
            'semester_id' => 1,
            'term_id' => 1,
        ]);

        PlanSumatifValueTechnique::create([
            'plan_sumatif_value_id' => 1,
            'code' => '1',
            'technique' => '1',
            'weighting' => '70',
        ]);

        PlanSumatifValueTechnique::create([
            'plan_sumatif_value_id' => 1,
            'code' => '2',
            'technique' => '2',
            'weighting' => '70',
        ]);

        PlanSumatifValueTechnique::create([
            'plan_sumatif_value_id' => 1,
            'code' => '3',
            'technique' => '3',
            'weighting' => '70',
        ]);
    }
}
