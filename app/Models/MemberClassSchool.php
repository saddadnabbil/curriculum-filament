<?php

namespace App\Models;

use App\Models\GradePromotion;
use App\Models\HomeroomNotes;
use App\Models\StudentAttendance;
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

    public function gradings()
    {
        return $this->hasMany(Grading::class);
    }

    public function studentAttendances()
    {
        return $this->hasMany(StudentAttendance::class);
    }

    public function extracurricular()
    {
        return $this->belongsToMany(Extracurricular::class, 'member_extracurriculars');
    }

    public function extracurricularAssessments()
    {
        return $this->hasManyThrough(ExtracurricularAssessment::class, MemberExtracurricular::class, 'member_class_school_id', 'member_extracurricular_id');
    }

    public function getFormativeAverageAttribute()
    {
        return round($this->gradings->avg(function ($grading) {
            return ($grading->formatif_technique_1 + $grading->formatif_technique_2 + $grading->formatif_technique_3) / 3;
        }));
    }

    public function getSummativeAverageAttribute()
    {
        return round($this->gradings->avg(function ($grading) {
            return ($grading->sumatif_technique_1 + $grading->sumatif_technique_2 + $grading->sumatif_technique_3) / 3;
        }));
    }

    public function getNilaiAkhirAttribute()
    {
        return round(($this->gradings->avg(function ($grading) {
            return ($grading->nilai_akhir);
        })), 2);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (is_array($model->student_id)) {
                $academicYearId = $model->academic_year_id;
                $studentIds = $model->student_id;
                unset($model->student_id); // Remove student_id to prevent array error

                foreach ($studentIds as $studentId) {
                    // Create individual MemberClassSchool records for each student
                    $memberClassSchool = self::create([
                        'student_id' => $studentId,
                        'class_school_id' => $model->class_school_id,
                        'academic_year_id' => $academicYearId,
                        'registration_type' => $model->registration_type,
                    ]);

                    // Create StudentAttendance for each member class school record
                    StudentAttendance::create([
                        'member_class_school_id' => $memberClassSchool->id,
                        'class_school_id' => $model->class_school_id,
                    ]);

                    HomeroomNotes::create([
                        'member_class_school_id' => $memberClassSchool->id,
                        'class_school_id' => $model->class_school_id,
                    ]);

                    GradePromotion::create([
                        'member_class_school_id' => $memberClassSchool->id,
                        'class_school_id' => $model->class_school_id,
                    ]);
                }

                // save to student model for class_school_id
                $student = Student::find($studentIds[0]);
                $student->class_school_id = $model->class_school_id;
                $student->save();

                // Prevent the original creation since we've handled it manually
                return false;
            }
        });

        // after delete
        static::deleting(function ($model) {
            $model->student()->update(['class_school_id' => null]);
            $model->studentAttendance()->update(['class_school_id' => null]);
        });
    }
}
