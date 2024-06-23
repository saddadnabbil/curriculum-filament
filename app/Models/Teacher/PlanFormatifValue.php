<?php

namespace App\Models\Teacher;

use App\Models\MasterData\LearningData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanFormatifValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'learning_data_id',
        'semester_id',
        'term_id',
    ];

    public function techniques()
    {
        return $this->hasMany(PlanFormatifValueTechnique::class);
    }

    public function learningData()
    {
        return $this->belongsTo(LearningData::class);
    }
}
