<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Extracurricular;
use App\Models\MemberExtracurricular;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExtracurricularAssessment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class);
    }

    public function memberExtracurricular()
    {
        return $this->belongsTo(MemberExtracurricular::class);
    }
}
