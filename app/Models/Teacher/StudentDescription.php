<?php

namespace App\Models\Teacher;

use App\Models\MasterData\Term;
use App\Models\MasterData\LearningData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentDescription extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function learningData()
    {
        return $this->hasMany(LearningData::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function grading()
    {
        return $this->hasMany(Grading::class);
    }
}
