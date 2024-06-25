<?php

namespace Database\Seeders;

use App\Models\MappingSubject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MappingSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MappingSubject::create([
            'subject_id' => 1,
            'group' => 'A',
            'order' => 1
        ]);

        MappingSubject::create([
            'subject_id' => 2,
            'group' => 'B',
            'order' => 2
        ]);

        MappingSubject::create([
            'subject_id' => 3,
            'group' => 'B',
            'order' => 3
        ]);
    }
}
