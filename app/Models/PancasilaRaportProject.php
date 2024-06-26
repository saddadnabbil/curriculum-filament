<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use SolutionForest\FilamentTree\Concern\ModelTree;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PancasilaRaportProject extends Model
{
    use HasFactory;
    use ModelTree;

    protected $fillable = ["parent_id", "title", "order", "teacher_id", "pancasila_raport_group_id"];

    protected $table = 'pancasila_raport_projects';

    protected static function booted(): void
    {
        static::addGlobalScope('activeProjectGroup', function (Builder $builder) {
            $builder->where('teacher_id', auth()->user()->teacher->first()->id);
        });

        static::creating(function (PancasilaRaportProject $PancasilaRaportProject) {
            $PancasilaRaportProject->teacher_id = auth()->user()->teacher->first()->id;
        });
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(PancasilaRaportProject::class);
    }

    // public function children()
    // {
    //     return $this->hasMany(PancasilaRaportProject::class, 'parent_id');
    // }

    public function hasParentId($id)
    {
        // Cek apakah parent_id saat ini cocok dengan id yang dicari
        if ($this->parent_id == $id) {
            return true;
        }

        // Jika tidak ada parent, kembalikan false
        if ($this->parent == null) {
            return false;
        }

        // Lanjutkan pengecekan ke parent record
        return $this->parent->hasParentId($id);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }


    public function getNameAttribute(): string
    {
        return $this->title;
    }
}
