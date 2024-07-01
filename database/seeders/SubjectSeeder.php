<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $mapelData = [];
        $namaMapelArray = [
            'Informatics', 'Mathematics', 'Indonesian Language', 'English Language', 'Science', 'Social Studies', 'Arts and Culture', 'Religious Education', 'agama-islam', 'Geography', 'History',
        ];

        // Loop over the index of the $namaMapelArray
        foreach ($namaMapelArray as $index => $namaMapel) {
            $mapelData[] = [
                'academic_year_id' => 1,
                'name' => $namaMapel,
                'name_idn' => $namaMapel,
                'slug' => $namaMapel,
                'color' => $faker->hexColor(),
            ];
        }

        // Insert the generated records into the database
        DB::table('subjects')->insert($mapelData);
    }
}
