<?php

namespace App\Filament\Resources\Teacher\GradePromotionResource\Pages;

use App\Filament\Resources\Teacher\GradePromotionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGradePromotion extends EditRecord
{
    protected static string $resource = GradePromotionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
