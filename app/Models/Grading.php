<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Models\Term;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Model;
use App\Models\PlanSumatifValue;
use App\Models\PlanFormatifValue;
use App\Models\MemberClassSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grading extends Model
{
    use HasFactory;

    protected $fillable = [
        'semester_id',
        'term_id',
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
        'description',
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

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
