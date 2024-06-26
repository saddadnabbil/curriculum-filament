<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PancasilaRaportProjectGroup extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::addGlobalScope('activeProjectGroup', function (Builder $builder) {
            $builder->where('teacher_id', auth()->user()->teacher->first()->id);
        });

        static::creating(function (PancasilaRaportProjectGroup $PancasilaRaportProjectGroup) {
            $PancasilaRaportProjectGroup->teacher_id = auth()->user()->teacher->first()->id;
        });
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subProject(): HasMany
    {
        return $this->hasMany(PancasilaRaportProject::class, 'project_group_id');
    }
}
