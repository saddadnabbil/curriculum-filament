<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MemberExtracurricular;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MemberExtracurricularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MemberExtracurricular::create([
            'extracurricular_id' => 1,
            'member_class_school_id' => 1
        ]);

        MemberExtracurricular::create([
            'extracurricular_id' => 1,
            'member_class_school_id' => 2
        ]);
    }
}
