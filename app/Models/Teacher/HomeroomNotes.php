<?php

namespace App\Models\Teacher;

use App\Models\MasterData\ClassSchool;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\MemberClassSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomeroomNotes extends Model
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
}
