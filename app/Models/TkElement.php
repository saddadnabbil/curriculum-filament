<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TkElement extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function getLevelNameAttribute()
    {
        return $this->level->name;
    }
}
