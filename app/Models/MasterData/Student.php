<?php

namespace App\Models\MasterData;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassSchool::class);
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
