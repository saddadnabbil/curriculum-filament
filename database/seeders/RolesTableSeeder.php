<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ["super_admin", "admin", 'admission', 'curriculum', 'teacher', 'co_teacher', 'teacher_pg_kg', 'co_teacher_pg_kg', "student"];

        // custom permissions
        $permissions = [
            'can_access_panel_admin',
            'can_access_panel_curriculum',
            'can_access_panel_admission',
            'can_access_panel_teacher',
            'can_access_panel_teacher_pg_kg',
        ];

        foreach ($permissions as $key => $permission) {
            DB::table('permissions')->insert(
                [
                    'name' => $permission,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        foreach ($roles as $key => $role) {
            DB::table('roles')->insert(
                [
                    'name' => $role,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
