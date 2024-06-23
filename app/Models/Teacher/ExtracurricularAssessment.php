<?php

namespace App\Models\Teacher;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Extracurricular;
use App\Models\MasterData\MemberExtracurricular;
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
