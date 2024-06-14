<?php

namespace App\Models\MasterData;

use Filament\Forms\Get;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassSchool extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function student(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function memberClassSchools(): HasMany
    {
        return $this->hasMany(MemberClassSchool::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    protected static function boot()
    {
        parent::boot();


        static::saved(function ($classSchool) {
            if (request()->has('member_students')) {
                $studentIds = request('member_students');
                $classSchool->students()->sync($studentIds);

                // Add logic to insert into member_class_schools
                foreach ($studentIds as $studentId) {
                    DB::table('member_class_schools')->updateOrInsert([
                        'student_id' => $studentId,
                        'class_school_id' => $classSchool->id,
                        'academic_year_id' => $classSchool->academic_year_id,
                    ]);
                }

                dd($studentIds);
            }
        });
    }
}
