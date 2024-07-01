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
            'learning_data_id' => 1,
        ]);

        Grading::create([
            'semester_id' => 1,
            'term_id' => 1,
            'member_class_school_id' => 2,
            'plan_formatif_value_id' => '1',
            'plan_sumatif_value_id' => '1',
            'learning_data_id' => 1,
        ]);

        Grading::create([
            'semester_id' => 1,
            'term_id' => 2,
            'member_class_school_id' => 1,
            'plan_formatif_value_id' => '2',
            'plan_sumatif_value_id' => '2',
            'learning_data_id' => 1,
        ]);

        Grading::create([
            'semester_id' => 1,
            'term_id' => 2,
            'member_class_school_id' => 2,
            'plan_formatif_value_id' => '2',
            'plan_sumatif_value_id' => '2',
            'learning_data_id' => 1,
        ]);

        // subject 2
        Grading::create([
            'semester_id' => 1,
            'term_id' => 1,
            'member_class_school_id' => 1,
            'plan_formatif_value_id' => '3',
            'plan_sumatif_value_id' => '3',
            'learning_data_id' => 2,
        ]);

        Grading::create([
            'semester_id' => 1,
            'term_id' => 1,
            'member_class_school_id' => 2,
            'plan_formatif_value_id' => '3',
            'plan_sumatif_value_id' => '3',
            'learning_data_id' => 2,
        ]);

        Grading::create([
            'semester_id' => 1,
            'term_id' => 2,
            'member_class_school_id' => 1,
            'plan_formatif_value_id' => '4',
            'plan_sumatif_value_id' => '4',
            'learning_data_id' => 2,
        ]);

        Grading::create([
            'semester_id' => 1,
            'term_id' => 2,
            'member_class_school_id' => 2,
            'plan_formatif_value_id' => '4',
            'plan_sumatif_value_id' => '4',
            'learning_data_id' => 2,
        ]);

        ////semester 2
        Grading::create([
            'semester_id' => 2,
            'term_id' => 1,
            'member_class_school_id' => 1,
            'plan_formatif_value_id' => '5',
            'plan_sumatif_value_id' => '5',
            'learning_data_id' => 1,
        ]);

        Grading::create([
            'semester_id' => 2,
            'term_id' => 1,
            'member_class_school_id' => 2,
            'plan_formatif_value_id' => '5',
            'plan_sumatif_value_id' => '5',
            'learning_data_id' => 1,
        ]);

        Grading::create([
            'semester_id' => 2,
            'term_id' => 2,
            'member_class_school_id' => 1,
            'plan_formatif_value_id' => '6',
            'plan_sumatif_value_id' => '6',
            'learning_data_id' => 1,
        ]);

        Grading::create([
            'semester_id' => 2,
            'term_id' => 2,
            'member_class_school_id' => 2,
            'plan_formatif_value_id' => '6',
            'plan_sumatif_value_id' => '6',
            'learning_data_id' => 1,
        ]);

        // subject 2
        Grading::create([
            'semester_id' => 2,
            'term_id' => 1,
            'member_class_school_id' => 1,
            'plan_formatif_value_id' => '7',
            'plan_sumatif_value_id' => '7',
            'learning_data_id' => 2,
        ]);

        Grading::create([
            'semester_id' => 2,
            'term_id' => 1,
            'member_class_school_id' => 2,
            'plan_formatif_value_id' => '7',
            'plan_sumatif_value_id' => '7',
            'learning_data_id' => 2,
        ]);

        Grading::create([
            'semester_id' => 2,
            'term_id' => 2,
            'member_class_school_id' => 1,
            'plan_formatif_value_id' => '8',
            'plan_sumatif_value_id' => '8',
            'learning_data_id' => 2,
        ]);

        Grading::create([
            'semester_id' => 2,
            'term_id' => 2,
            'member_class_school_id' => 2,
            'plan_formatif_value_id' => '8',
            'plan_sumatif_value_id' => '8',
            'learning_data_id' => 2,
        ]);
    }
}
