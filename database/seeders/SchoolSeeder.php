<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // PG/KG
        School::create([
            'academic_year_id' => 1,
            'school_name' => 'Global Indonesia PG/KG',
            'npsn' => '0000000000',
            'postal_code' => '62001',
            'address' => 'Perumahan Emerald Lake, Jl. Raya Tasikardi, Pelamunan, Kramatwatu, Serang-Banten, 42161 Kabupaten Serang, Banten.',
            // 'logo' => 'logo.png',
            'number_phone' => '0254-7941564',
            'email' => 'admin@gis.com',
            'nip_principal' => '111111111111111111',
            'principal' => 'IVAN SENEVIRATNE, M.ED',
        ]);

        // SD
        School::create([
            'academic_year_id' => 1,
            'school_name' => 'Global Indonesia Primary School',
            'npsn' => '0000000000',
            'postal_code' => '62001',
            'address' => 'Perumahan Emerald Lake, Jl. Raya Tasikardi, Pelamunan, Kramatwatu, Serang-Banten, 42161 Kabupaten Serang, Banten.',
            // 'logo' => 'logo.png',
            'number_phone' => '0254-7941564',
            'email' => 'admin@gis.com',
            'nip_principal' => '111111111111111111',
            'principal' => 'IVAN SENEVIRATNE, M.ED',
        ]);

        // smp
        School::create([
            'academic_year_id' => 1,
            'school_name' => 'Global Indonesia Junior High School',
            'npsn' => '0000000000',
            'postal_code' => '62001',
            'address' => 'Perumahan Emerald Lake, Jl. Raya Tasikardi, Pelamunan, Kramatwatu, Serang-Banten, 42161 Kabupaten Serang, Banten.',
            // 'logo' => 'logo.png',
            'number_phone' => '0254-7941564',
            'email' => 'admin@gis.com',
            'nip_principal' => '111111111111111111',
            'principal' => 'IVAN SENEVIRATNE, M.ED',
        ]);

        // sma
        School::create([
            'academic_year_id' => 1,
            'school_name' => 'Global Indonesia Senior High School',
            'npsn' => '0000000000',
            'postal_code' => '62001',
            'address' => 'Perumahan Emerald Lake, Jl. Raya Tasikardi, Pelamunan, Kramatwatu, Serang-Banten, 42161 Kabupaten Serang, Banten.',
            // 'logo' => 'logo.png',
            'number_phone' => '0254-7941564',
            'email' => 'admin@gis.com',
            'nip_principal' => '111111111111111111',
            'principal' => 'IVAN SENEVIRATNE, M.ED',
        ]);
    }
}
