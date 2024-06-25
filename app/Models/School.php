<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    // public function scopeWithActiveAcademicYear($query)
    // {
    //     return $query->whereHas('academicYear', function ($query) {
    //         $query->where('status', true);
    //     });
    // }
}
