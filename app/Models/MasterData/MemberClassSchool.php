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
}
