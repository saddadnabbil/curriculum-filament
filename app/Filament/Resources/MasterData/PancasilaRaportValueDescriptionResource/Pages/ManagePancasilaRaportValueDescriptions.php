<?php

namespace App\Filament\Resources\MasterData\PancasilaRaportValueDescriptionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Models\PancasilaRaportValueDescription;
use App\Filament\Resources\MasterData\PancasilaRaportValueDescriptionResource;

class ManagePancasilaRaportValueDescriptions extends ManageRecords
{
    protected static string $resource = PancasilaRaportValueDescriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Actions\Action::make('createMaster')
                ->action(function () {
                    PancasilaRaportValueDescription::updateOrCreate(
                        ['title' => 'Mulai Berkembang'],
                        ['description' => 'Siswa masih membutuhkan bimbingan dalam mengembangkan kemampuan.']
                    );
                    PancasilaRaportValueDescription::updateOrCreate(
                        ['title' => 'Sedang Berkembang'],
                        ['description' => 'Siswa mulai mengembangkan kemampuan namun belum baik.']
                    );
                    PancasilaRaportValueDescription::updateOrCreate(
                        ['title' => 'Berkembang Sesuai Harapan'],
                        ['description' => 'Siswa telah mengembangkan kemampuan hingga ke tahap baik.']
                    );
                    PancasilaRaportValueDescription::updateOrCreate(
                        ['title' => 'Sangat Berkembang'],
                        ['description' => 'Siswa mengembangkan kemampuan melampaui harapan.']
                    );
                }),
        ];
    }
}
