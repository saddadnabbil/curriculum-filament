<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models;
use App\Models\Line;
use App\Models\Level;
use App\Models\School;
use App\Models\Grading;
use App\Models\Silabus;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\ClassSchool;
use App\Models\AcademicYear;
use App\Models\LearningData;
use App\Policies\RolePolicy;
use App\Models\HomeroomNotes;
use App\Models\GradePromotion;
use App\Models\Extracurricular;
use App\Models\LearningOutcome;
use App\Models\PlanSumatifValue;
use App\Policies\ActivityPolicy;
use App\Models\PlanFormatifValue;
use App\Models\StudentAttendance;
use App\Policies\ExceptionPolicy;
use App\Models\StudentAchievement;
use App\Models\StudentDescription;
use Spatie\Permission\Models\Role;
use App\Policies\MasterData\LinePolicy;
use App\Policies\Teacher\GradingPolicy;
use Spatie\Activitylog\Models\Activity;
use App\Policies\MasterData\LevelPolicy;
use App\Models\ExtracurricularAssessment;
use App\Models\MemberClassSchool;
use App\Policies\MasterData\SchoolPolicy;
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
use App\Policies\Teacher\PlanFormatifValuePolicy;
use App\Policies\Teacher\StudentAttendancePolicy;
use App\Policies\MasterData\ExtracurricularPolicy;
use App\Policies\Teacher\StudentAchievementPolicy;
use App\Policies\Teacher\StudentDescriptionPolicy;
use BezhanSalleh\FilamentExceptions\Models\Exception;
use App\Policies\Teacher\ExtracurricularAssessmentPolicy;
use App\Policies\Teacher\LegerPolicy;
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
        MemberClassSchool::class => LegerPolicy::class,

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
