<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Employee extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    // Relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

    // Media
    public function getFilamentPasPhotoUrl(): ?string
    {
        return $this->getMedia('pas_photo')->first()->getUrl() ?? null;
    }

    public function getFilamentTtdUrl(): ?string
    {
        return $this->getMedia('ttd')->first()->getUrl() ?? null;
    }

    public function getFilamentPhotoKartuIdentitasUrl(): ?string
    {
        return $this->getMedia('photo_kartu_identitas')->first()->getUrl() ?? null;
    }

    public function getFilamentPhotoTaxPayerUrl(): ?string
    {
        return $this->getMedia('photo_tax_payer')->first()->getUrl() ?? null;
    }

    public function getFilamentPhotoKkUrl(): ?string
    {
        return $this->getMedia('photo_kk')->first()->getUrl() ?? null;
    }

    public function getFilamentOtherDocumentUrl(): ?string
    {
        return $this->getMedia('other_document')->first()->getUrl() ?? null;
    }

    // Define conversions for ttd and photo_kartu_identitas
    public function registerMediaConversions(Media $media = null): void
    {
        // Conversion for employee
        $this->addMediaConversion('employee')
            ->fit(Fit::Contain, 200, 200)
            ->nonQueued();

        // Conversion for ttd
        $this->addMediaConversion('ttd')
            ->fit(Fit::Contain, 100, 100)
            ->nonQueued();

        // Conversion for photo_kartu_identitas
        $this->addMediaConversion('photo_kartu_identitas')
            ->fit(Fit::Contain, 200, 200)
            ->nonQueued();

        // Conversion for photo_tax_payer
        $this->addMediaConversion('photo_tax_payer')
            ->fit(Fit::Contain, 200, 200)
            ->nonQueued();

        // Conversion for photo_kk
        $this->addMediaConversion('photo_kk')
            ->fit(Fit::Contain, 200, 200)
            ->nonQueued();

        // Conversion for other_document
        $this->addMediaConversion('other_document')
            ->fit(Fit::Contain, 200, 200)
            ->nonQueued();
    }
}
