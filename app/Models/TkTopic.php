<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TkTopic extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function element()
    {
        return $this->belongsTo(TkElement::class, 'tk_element_id');
    }
}
