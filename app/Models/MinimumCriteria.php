<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinimumCriteria extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function learningData()
    {
        return $this->belongsTo(LearningData::class);
    }

    public function classSchool()
    {
        return $this->belongsTo(ClassSchool::class);
    }
}
