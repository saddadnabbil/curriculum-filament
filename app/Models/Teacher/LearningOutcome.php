<?php

namespace App\Models\Teacher;

use App\Models\MasterData\Subject;
use App\Models\MasterData\Semester;
use App\Models\MasterData\AcademicYear;
use App\Models\MasterData\LearningData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningOutcome extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'learning_outcomes' => 'array',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function learningData()
    {
        return $this->belongsTo(LearningData::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
