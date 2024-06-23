<?php

namespace App\Models\Teacher;

use App\Models\MasterData\LearningData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanFormatifValueTechnique extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_formatif_value_id',
        'technique',
        'weighting',
        'code',
    ];

    public function planFormatifValue()
    {
        return $this->belongsTo(PlanFormatifValue::class);
    }
}
