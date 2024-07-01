<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
