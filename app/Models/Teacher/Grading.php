<?php

namespace App\Models\Teacher;

use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher\PlanSumatifValue;
use App\Models\Teacher\PlanFormatifValue;
use App\Models\MasterData\MemberClassSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grading extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_class_school_id',
        'plan_formatif_value_id',
        'plan_sumatif_value_id',
        'formatif_technique_1',
        'formatif_technique_2',
        'formatif_technique_3',
        'sumatif_technique_1',
        'sumatif_technique_2',
        'sumatif_technique_3',
        'nilai_akhir',
        'nilai_revisi',
    ];

    public function memberClassSchool()
    {
        return $this->belongsTo(MemberClassSchool::class);
    }

    public function planFormatifValue()
    {
        return $this->belongsTo(PlanFormatifValue::class);
    }

    public function planSumatifValue()
    {
        return $this->belongsTo(PlanSumatifValue::class);
    }
}
