<?php

namespace App\Models;

use App\Models\MasterData\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relation
    public function employeeUnit()
    {
        return $this->belongsTo(EmployeeUnit::class);
    }

    public function employeePosition()
    {
        return $this->belongsTo(EmployeePosition::class);
    }

    public function employeeStatus()
    {
        return $this->belongsTo(EmployeeStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
