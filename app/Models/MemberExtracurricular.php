<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberExtracurricular extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function memberClassSchool()
    {
        return $this->belongsTo(MemberClassSchool::class);
    }

    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (is_array($model->member_class_school_id)) {
                $memberClassSchoolIds = $model->member_class_school_id;
                unset($model->member_class_school_id);

                foreach ($memberClassSchoolIds as $memberClassSchoolId) {
                    self::create([
                        'member_class_school_id' => $memberClassSchoolId,
                        'extracurricular_id' => $model->extracurricular_id,
                    ]);
                }

                // Prevent the original creation since we've handled it manually
                return false;
            }
        });
    }
}
