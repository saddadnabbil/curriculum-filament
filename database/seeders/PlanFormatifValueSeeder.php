<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher\PlanFormatifValue;
use App\Models\Teacher\PlanFormatifValueTechnique;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlanFormatifValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlanFormatifValue::create([
            'learning_data_id' => 1,
            'semester_id' => 1,
            'term_id' => 1,
        ]);

        PlanFormatifValueTechnique::create([
            'plan_formatif_value_id' => 1,
            'code' => '1',
            'technique' => '1',
            'weighting' => '70',
        ]);

        PlanFormatifValueTechnique::create([
            'plan_formatif_value_id' => 1,
            'code' => '2',
            'technique' => '2',
            'weighting' => '70',
        ]);

        PlanFormatifValueTechnique::create([
            'plan_formatif_value_id' => 1,
            'code' => '3',
            'technique' => '3',
            'weighting' => '70',
        ]);
    }
}
