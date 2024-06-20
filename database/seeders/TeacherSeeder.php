<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterData\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::create([
            'employee_id' => 1,
        ]);
        Teacher::create([
            'employee_id' => 2,
        ]);

        Teacher::create([
            'employee_id' => 3,
        ]);

        Teacher::create([
            'employee_id' => 4,
        ]);
    }
}
