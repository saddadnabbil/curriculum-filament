<?php

namespace App\Models\MasterData;

use App\Models\Teacher\StudentAttendance;
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

    public function studentAttendance()
    {
        return $this->belongsTo(StudentAttendance::class);
    }

    public function extracurricular()
    {
        return $this->belongsToMany(Extracurricular::class, 'member_extracurriculars');
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
