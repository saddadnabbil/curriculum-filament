<?php

namespace App\Models;

use App\Models\LearningData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanSumatifValueTechnique extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_sumatif_value_id',
        'technique',
        'weighting',
        'code',
    ];

    public function planSumatifValue()
    {
        return $this->belongsTo(PlanSumatifValue::class);
    }
}
