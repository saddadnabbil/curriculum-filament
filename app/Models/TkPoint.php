<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TkPoint extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function subtopic()
    {
        return $this->belongsTo(TkSubtopic::class, 'tk_subtopic_id');
    }

    public function topic()
    {
        return $this->belongsTo(TkTopic::class, 'tk_topic_id');
    }

    public function getElementAttribute()
    {
        // Ensure the relationship is loaded
        if (!$this->relationLoaded('topic')) {
            $this->load('topic');
        }

        // Check if the topic relationship exists
        return $this->topic ? $this->topic->element : null;
    }

    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id');
    }
}
