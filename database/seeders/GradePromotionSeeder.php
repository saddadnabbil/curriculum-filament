<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher\GradePromotion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GradePromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GradePromotion::create([
            'class_school_id' => 8,
            'member_class_school_id' => 1,
            'destination_class' => '7b'
        ]);

        GradePromotion::create([
            'class_school_id' => 8,
            'member_class_school_id' => 2,
            'destination_class' => '7b'
        ]);
    }
}
