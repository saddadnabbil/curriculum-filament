<?php

namespace App\Models\MasterData;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getEmployeeFullnameAttribute()
    {
        return $this->employee ? $this->employee->fullname : null;
    }

    public function extracurricular()
    {
        return $this->hasMany(Extracurricular::class);
    }

    public function classSchool()
    {
        return $this->hasMany(ClassSchool::class);
    }
}
