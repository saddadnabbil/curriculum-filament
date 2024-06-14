<?php

namespace App\Models\MasterData;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classSchool()
    {
        return $this->belongsTo(ClassSchool::class);
    }

    public function classSchools()
    {
        return $this->belongsToMany(ClassSchool::class, 'member_class_schools')
            ->withPivot('academic_year_id', 'registration_type')
            ->withTimestamps();
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function line()
    {
        return $this->belongsTo(Line::class);
    }
}
