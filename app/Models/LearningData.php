<?php

namespace App\Models;

use App\Models\LearningOutcome;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningData extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function classSchool()
    {
        return $this->belongsTo(ClassSchool::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function learningOutcome()
    {
        return $this->hasMany(LearningOutcome::class);
    }

    public function scopeFilterByTeacher($query)
    {
        $user = auth()->user();
        if ($user && $user->employee && $user->employee->teacher) {
            $teacherId = $user->employee->teacher->id;
            return $query->where('teacher_id', $teacherId);
        }

        return $query;
    }
}
