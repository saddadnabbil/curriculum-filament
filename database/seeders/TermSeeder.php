<?php

namespace Database\Seeders;

use App\Models\Term;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Term::create([
            'term' => 1,
        ]);

        Term::create([
            'term' => 2,
        ]);

        Term::create([
            'term' => 3,
        ]);

        Term::create([
            'term' => 4,
        ]);
    }
}
