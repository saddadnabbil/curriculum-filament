<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $this->createSuperAdmin();
        $this->createRegularUsers();
    }

    private function createSuperAdmin(): void
    {
        $superAdmin = User::create([
            'username' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('superadmin'),
            'status' => true,
        ]);

        // Bind superadmin user to FilamentShield
        Artisan::call('shield:super-admin', ['--user' => $superAdmin->id]);

        // Create associated employee for super admin
        Employee::create([
            'user_id' => $superAdmin->id,
            'employee_status_id' => 1,
            'employee_unit_id' => 2,
            'employee_position_id' => 1,
            'join_date' => '2022-01-01',
            'resign_date' => null,
            'permanent_date' => '2023-01-01',
            'kode_karyawan' => 'K002', // Change as needed
            'nama_lengkap' => 'Super Admin', // Change as needed
            'nik' => '1234567890123412', // Change as needed
            'nomor_akun' => '123456719', // Change as needed
            'nomor_fingerprint' => '123', // Change as needed
            // Populate other fields as needed
        ]);
    }

    private function createRegularUsers(): void
    {
        $faker = \Faker\Factory::create();

        $roles = Role::whereNot('name', 'super_admin')->get();
        foreach ($roles as $role) {
            for ($i = 0; $i < 2; $i++) {
                $user = User::create([
                    'username' => $faker->unique()->userName,
                    'email' => $faker->unique()->safeEmail,
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'status' => 1,
                ]);

                DB::table('model_has_roles')->insert([
                    'role_id' => $role->id,
                    'model_type' => 'App\Models\User',
                    'model_id' => $user->id,
                ]);

                // Create associated employee
                Employee::create([
                    'user_id' => $user->id,
                    'employee_status_id' => 1,
                    'employee_unit_id' => 2,
                    'employee_position_id' => 1,
                    'join_date' => '2022-01-01',
                    'resign_date' => null,
                    'permanent_date' => '2023-01-01',
                    'kode_karyawan' => strtoupper($faker->unique()->regexify('[A-Za-z0-9]{6}')),
                    'nama_lengkap' => $faker->name,
                    'nik' => $faker->unique()->numerify('################'), // Generates a random 16-digit number
                    'nomor_akun' => $faker->unique()->numerify('#########'), // Generates a random 9-digit number
                    'nomor_fingerprint' => $faker->unique()->numerify('###'),
                    // Populate other fields as needed
                    'jenis_kelamin' => $faker->randomElement(['1', '2']),
                    'agama' => $faker->randomElement(['1', '2', '3', '4', '5', '6', '7']),
                    'tempat_lahir' => $faker->city,
                    'tanggal_lahir' => $faker->date,
                    'alamat' => $faker->address,
                    'alamat_sekarang' => $faker->address,
                    'kota' => $faker->city,
                    'kode_pos' => $faker->postcode,
                    'nomor_phone' => $faker->phoneNumber,
                    'nomor_hp' => $faker->phoneNumber,
                    'email' => $faker->unique()->safeEmail,
                    'email_sekolah' => $faker->unique()->safeEmail,
                    'warga_negara' => $faker->country,
                    'status_pernikahan' => $faker->randomElement(['1', '2', '3', '4']),
                    'nama_pasangan' => $faker->name,
                    'jumlah_anak' => $faker->randomDigit,
                    'keterangan' => $faker->sentence,
                ]);
            }
        }
    }
}
