<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterData\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            ["name" => "Playgroup", "school_id" => 1],
            ["name" => "Kindergarten A", "school_id" => 1],
            ["name" => "Kindergarten B", "school_id" => 1],
            ["name" => "Primary School", "school_id" => 2],
            ["name" => "Junior High School", "school_id" => 3],
            ["name" => "Senior High School", "school_id" => 4],
        ];

        foreach ($datas as $data) {
            Level::create([
                'name' => $data['name'],
                'term_id' => 1,
                'semester_id' => 1,
                'school_id' => $data['school_id'],
            ]);
        }
    }
}
