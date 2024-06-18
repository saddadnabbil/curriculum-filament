<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberClassSchool extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function classSchool()
    {
        return $this->belongsTo(ClassSchool::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (is_array($model->student_id)) {
                $academicYearId = $model->academic_year_id;
                $studentIds = $model->student_id;
                unset($model->student_id); // Remove student_id to prevent array error

                foreach ($studentIds as $studentId) {
                    self::create([
                        'student_id' => $studentId,
                        'class_school_id' => $model->class_school_id,
                        'academic_year_id' => $academicYearId,
                        'registration_type' => $model->registration_type,
                    ]);
                }

                // Prevent the original creation since we've handled it manually
                return false;
            }
        });
    }
}
