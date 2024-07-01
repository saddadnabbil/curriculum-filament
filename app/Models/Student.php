<?php

namespace App\Models;

use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classSchool()
    {
        return $this->belongsTo(ClassSchool::class);
    }

    public function classSchools()
    {
        return $this->belongsToMany(ClassSchool::class, 'member_class_schools')
            ->withPivot('academic_year_id', 'registration_type')
            ->withTimestamps();
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function scopeOwnStudent(Builder $query): void
    {
        if (auth()->user()->teacher->count()) {
            $classSchool = ClassSchool::where('teacher_id', auth()->user()->employee->teacher->first()->id)->where('academic_year_id', Helper::getActiveAcademicYearId());
            $query->whereIn('id', MemberClassSchool::where('academic_year_id', Helper::getActiveAcademicYearId())
                ->whereIn('class_school_id', $classSchool->pluck('id'))
                ->get()->pluck('student_id')->toArray());
        }
    }

    public function pancasilaRaportProjects(): BelongsToMany
    {
        return $this->belongsToMany(PancasilaRaportProject::class, 'student_pancasila_raports')->as('pancasila_raport_projects');
    }

    public function pancasilaRaport(): HasMany
    {
        return $this->hasMany(StudentPancasilaRaport::class);
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            if ($model->class_school_id) {
                $academicYearId = AcademicYear::where('status', true)->first()->id;

                $classSchool = ClassSchool::where('id', $model->class_school_id)->where('academic_year_id', $academicYearId)->find($model->class_school_id);

                //create or update update memberClassSchool when student_id is $model->id and academic_year_id is $academicYearId

                if (!$classSchool) {
                    // notify warning when saving newest classSchool
                    Notification::make()
                        ->warning()
                        ->title('Whopps, cant save newest class school')
                        ->body("Class school not found in this academic year. Contact your administrator.")
                        ->send();

                    return false;
                } else {
                    $memberClassSchool = MemberClassSchool::updateOrCreate(
                        ['student_id' => $model->id, 'academic_year_id' => $academicYearId],
                        ['class_school_id' => $classSchool->id, 'registration_type' => $model->registration_type]
                    );
                }

                // MemberClassSchool::where('student_id', $model->id)
                //     ->where('academic_year_id', $academicYearId)
                //     ->update(['class_school_id' => $classSchool->id]);

            }
        });
    }
}
