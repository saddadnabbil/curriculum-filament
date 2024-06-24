<?php

namespace App\Models\Teacher;

use App\Models\MasterData\ClassSchool;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\MemberClassSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GradePromotion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function memberClassSchool()
    {
        return $this->belongsTo(MemberClassSchool::class);
    }

    public function classSchool()
    {
        return $this->belongsTo(ClassSchool::class);
    }

    public function destinationClassSchool()
    {
        return $this->belongsTo(ClassSchool::class, 'destination_class_school_id');
    }
}
