<?php

namespace Database\Seeders;

use App\Models\MinimumCriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MinimumCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MinimumCriteria::create([
            'subject_id' => 1,
            'class_school_id' => 8,
            'kkm' => 75
        ]);

        MinimumCriteria::create([
            'subject_id' => 1,
            'class_school_id' => 2,
            'kkm' => 75
        ]);

        MinimumCriteria::create([
            'subject_id' => 2,
            'class_school_id' => 8,
            'kkm' => 75
        ]);

        MinimumCriteria::create([
            'subject_id' => 3,
            'class_school_id' => 9,
            'kkm' => 75
        ]);
    }
}
