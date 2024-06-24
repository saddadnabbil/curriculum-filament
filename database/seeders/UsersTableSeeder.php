<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\MasterData\Student;
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

    }

    private function createRegularUsers(): void
    {
        $faker = \Faker\Factory::create();

          // $roles = Role::whereNot('name', 'super_admin')->get();
        // foreach ($roles as $role) {
        //     for ($i = 0; $i < 1; $i++) {
        //         $user = User::create([
        //             'username' => $faker->unique()->userName,
        //             'email' => $faker->unique()->safeEmail,
        //             'email_verified_at' => now(),
        //             'password' => Hash::make('password'),
        //             'status' => 1,
        //         ]);

        //         if($role->name == 'student'){
        //             Student::create([
        //                 'user_id' => $user->id,
        //                 'full_name' => $faker->name,
        //                 'email' => $user->email,
        //                 'username' => $user->username,
        //                 'nis' => $faker->unique()->numerify('########'),
        //                 'nisn' => $faker->unique()->numerify('##########'),
        //                 'nik' => $faker->unique()->numerify('################'),
        //                 'registration_type' => $faker->randomElement(['1', '2']),
        //             ]);
        //         } else {
        //             // create employee
        //             Employee::create([
        //                 'user_id' => $user->id,

        //                 'employee_unit_id' => 1,
        //                 'employee_position_id' => 1,
        //                 'employee_status_id' => 1,
        //                 'full_name' => $faker->name,
        //                 'email' => $user->email,
        //                 'employee_code' => $faker->unique()->numerify('########'),
        //                 'nik' => $faker->unique()->numerify('################'),
        //             ]);
        //         }

        //         DB::table('model_has_roles')->insert([
        //             'role_id' => $role->id,
        //             'model_type' => 'App\Models\User',
        //             'model_id' => $user->id,
        //         ]);
        //     }
        // }
    }
}
