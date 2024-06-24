<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\EmployeeUnit;
use Illuminate\Database\Seeder;
use App\Models\EmployeePosition;
use App\Models\MasterData\AcademicYear;
use App\Models\Teacher\LearningOutcome;
use Illuminate\Support\Facades\Artisan;
use App\Models\MasterData\Extracurricular;
use App\Models\Teacher\PlanFormatifValue;
use Database\Seeders\MemberClassSchoolSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class,
            // UsersTableSeeder::class,

            LineSeeder::class,
            SemesterSeeder::class,
            TermSeeder::class,
            AcademicYearSeeder::class,
            SchoolSeeder::class,
            LevelSeeder::class,

            // // Timetable
            // JadwalPelajaranSlotTableSeeder::class,
            // TkJadwalPelajaranSlotTableSeeder::class,

            EmployeeStatusSeeder::class,
            EmployeeUnitSeeder::class,
            EmployeePositionSeeder::class,
            EmployeeSeeder::class,

            TeacherSeeder::class,
            ClassSchoolSeeder::class,
            StudentSeeder::class,
            // MemberClassSchoolSeeder::class,
            // PrestasiSiswaSeeder::class,
            ExtracurricularSeeder::class,
            MemberExtracurricularSeeder::class,
            SubjectSeeder::class,
            LearningDataSeeder::class,

            // KM Seeder
            LearningOutcomeSeeder::class,
            PlanFormatifValueSeeder::class,
            PlanSumatifValueSeeder::class,
            GradingSeeder::class,
            // KM Seeder (Homeroom)
            StudentAttendanceSeeder::class,
            StudentAchievementSeeder::class,
            HomeroomNotesSeeder::class,
            GradePromotionSeeder::class,
        ]);

        Artisan::call('shield:generate --all');
    }
}
