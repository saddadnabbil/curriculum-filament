<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\MasterData\Line;
use App\Models\MasterData\Level;
use App\Policies\ActivityPolicy;
use App\Models\MasterData\School;
use App\Policies\ExceptionPolicy;
use App\Models\MasterData\Student;
use App\Models\MasterData\Subject;
use App\Models\MasterData\Teacher;
use App\Models\MasterData\ClassSchool;
use App\Models\MasterData\AcademicYear;
use App\Models\MasterData\LearningData;
use App\Models\MasterData\Extracurricular;
use App\Policies\MasterData\LinePolicy;
use Spatie\Activitylog\Models\Activity;
use App\Policies\MasterData\LevelPolicy;
use App\Policies\MasterData\SchoolPolicy;
use App\Policies\MasterData\StudentPolicy;
use App\Policies\MasterData\SubjectPolicy;
use App\Policies\MasterData\TeacherPolicy;
use App\Policies\MasterData\ClassSchoolPolicy;
use App\Policies\MasterData\AcademicYearPolicy;
use App\Policies\MasterData\LearningDataPolicy;
use App\Policies\MasterData\ExtracurricularPolicy;
use BezhanSalleh\FilamentExceptions\Models\Exception;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Activity::class => ActivityPolicy::class,

        // MasterData
        School::class => SchoolPolicy::class,
        AcademicYear::class => AcademicYearPolicy::class,
        Student::class => StudentPolicy::class,
        Teacher::class => TeacherPolicy::class,
        Level::class => LevelPolicy::class,
        Line::class => LinePolicy::class,
        Subject::class => SubjectPolicy::class,
        ClassSchool::class => ClassSchoolPolicy::class,
        LearningData::class => LearningDataPolicy::class,
        Extracurricular::class => ExtracurricularPolicy::class,
        // Syllabus::class => SyllabusPolicy::class,
        // TimeTable::class => TimeTablePolicy::class,



        Exception::class => ExceptionPolicy::class,
        'Spatie\Permission\Models\Role' => 'App\Policies\RolePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
