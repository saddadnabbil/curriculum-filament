<?php

namespace App\Models;

use App\Models\LearningData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalPelajaranRecord extends Model
{
    use HasFactory;

    use HasFactory;

    protected $guarded = ['id'];

    public function jadwalPelajaranSlot()
    {
        return $this->belongsTo(JadwalPelajaranSlot::class);
    }

    public function learningData()
    {
        return $this->belongsTo(LearningData::class);
    }

    public function timeSlots()
    {
        return $this->hasMany(JadwalPelajaranSlot::class);
    }
}
