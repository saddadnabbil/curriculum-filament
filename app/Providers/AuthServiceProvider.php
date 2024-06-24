<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Policies\RolePolicy;
use App\Models\MasterData\Line;
use App\Models\Teacher\Grading;
use App\Models\MasterData\Level;
use App\Policies\ActivityPolicy;
use App\Models\MasterData\School;
use App\Policies\ExceptionPolicy;
use App\Models\MasterData\Silabus;
use App\Models\MasterData\Student;
use App\Models\MasterData\Subject;
use App\Models\MasterData\Teacher;
use Spatie\Permission\Models\Role;
use App\Models\Teacher\HomeroomNotes;
use App\Models\MasterData\ClassSchool;
use App\Models\Teacher\GradePromotion;
use App\Models\MasterData\AcademicYear;
use App\Models\MasterData\LearningData;
use App\Models\Teacher\LearningOutcome;
use App\Policies\MasterData\LinePolicy;
use App\Policies\Teacher\GradingPolicy;
use Spatie\Activitylog\Models\Activity;
use App\Models\Teacher\PlanSumatifValue;
use App\Policies\MasterData\LevelPolicy;
use App\Models\Teacher\PlanFormatifValue;
use App\Models\Teacher\StudentAttendance;
use App\Policies\MasterData\SchoolPolicy;
use App\Models\MasterData\Extracurricular;
use App\Models\Teacher\StudentAchievement;
use App\Models\Teacher\StudentDescription;
use App\Policies\MasterData\SilabusPolicy;
use App\Policies\MasterData\StudentPolicy;
use App\Policies\MasterData\SubjectPolicy;
use App\Policies\MasterData\TeacherPolicy;
use App\Policies\Teacher\StudentDataPolicy;
use App\Policies\Teacher\HomeroomNotesPolicy;
use App\Policies\MasterData\ClassSchoolPolicy;
use App\Policies\Teacher\GradePromotionPolicy;
use App\Policies\MasterData\AcademicYearPolicy;
use App\Policies\MasterData\LearningDataPolicy;
use App\Policies\Teacher\LearningOutcomePolicy;
use App\Policies\Teacher\PlanSumatifValuePolicy;
use App\Models\Teacher\ExtracurricularAssessment;
use App\Policies\Teacher\PlanFormatifValuePolicy;
use App\Policies\Teacher\StudentAttendancePolicy;
use App\Policies\MasterData\ExtracurricularPolicy;
use App\Policies\Teacher\StudentAchievementPolicy;
use App\Policies\Teacher\StudentDescriptionPolicy;
use BezhanSalleh\FilamentExceptions\Models\Exception;
use App\Policies\Teacher\ExtracurricularAssessmentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Role::class => RolePolicy::class, // Necessary for role permissions to work
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
        Silabus::class => SilabusPolicy::class,
        // TimeTable::class => TimeTablePolicy::class,

        ExtracurricularAssessment::class => ExtracurricularAssessmentPolicy::class,
        GradePromotion::class => GradePromotionPolicy::class,
        Grading::class => GradingPolicy::class,
        HomeroomNotes::class => HomeroomNotesPolicy::class,
        LearningOutcome::class => LearningOutcomePolicy::class,
        PlanFormatifValue::class => PlanFormatifValuePolicy::class,
        PlanSumatifValue::class => PlanSumatifValuePolicy::class,
        StudentAchievement::class => StudentAchievementPolicy::class,
        StudentAttendance::class => StudentAttendancePolicy::class,
        Student::class => StudentDataPolicy::class,
        StudentDescription::class => StudentDescriptionPolicy::class,

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
