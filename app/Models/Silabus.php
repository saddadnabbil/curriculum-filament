<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Silabus extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function classSchool()
    {
        return $this->belongsTo(ClassSchool::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
