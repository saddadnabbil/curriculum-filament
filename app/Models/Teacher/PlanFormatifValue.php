<?php

namespace App\Models\Teacher;

use App\Models\MasterData\LearningData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanFormatifValue extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function learningData()
    {
        return $this->belongsTo(LearningData::class);
    }
}
