<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TkAchivementEventGrade extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function memberClassSchool()
    {
        return $this->belongsTo(MemberClassSchool::class);
    }

    public function event()
    {
        return $this->belongsTo(TkEvent::class);
    }
}
