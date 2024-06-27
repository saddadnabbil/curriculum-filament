<?php

namespace Database\Seeders;

use App\Models\TkEvent;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TkEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TkEvent::create([
            'academic_year_id' => 1,
            'term_id' => 1,
            'name' => 'Event 1',
        ]);

        TkEvent::create([
            'academic_year_id' => 1,
            'term_id' => 1,
            'name' => 'Event 2',
        ]);

        TkEvent::create([
            'academic_year_id' => 1,
            'term_id' => 1,
            'name' => 'Event 3',
        ]);

        TkEvent::create([
            'academic_year_id' => 1,
            'term_id' => 1,
            'name' => 'Event 4',
        ]);
    }
}
