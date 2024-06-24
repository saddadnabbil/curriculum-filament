<?php

namespace Database\Seeders;

use App\Models\MasterData\Line;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = [
            "IPA",
            "IPS",
            "NON",
        ];

        foreach ($name as $name) {
            Line::create([
                'name' => $name
            ]);
        }
    }
}
