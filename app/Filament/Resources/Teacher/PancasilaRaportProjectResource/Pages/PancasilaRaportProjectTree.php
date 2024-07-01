<?php

namespace App\Filament\Resources\Teacher\PancasilaRaportProjectResource\Pages;

use Filament\Actions\Action;
use Filament\Pages\Actions\CreateAction;
// use SolutionForest\FilamentTree\Actions;
use SolutionForest\FilamentTree\Concern;
use SolutionForest\FilamentTree\Support\Utils;
use App\Filament\Resources\Teacher\PancasilaRaportProjectResource;
use SolutionForest\FilamentTree\Resources\Pages\TreePage as BasePage;

class PancasilaRaportProjectTree extends BasePage
{
    protected static string $resource = PancasilaRaportProjectResource::class;

    protected static int $maxDepth = 4;

    protected function getHeaderActions(): array
    {
        return [$this->getCreateAction(), Action::make('back')->outlined()->url(PancasilaRaportProjectResource::getUrl())];
    }

    protected function getActions(): array
    {
        return [
            $this->getCreateAction(),
            // SAMPLE CODE, CAN DELETE
            //\Filament\Pages\Actions\Action::make('sampleAction'),
        ];
    }

    protected function hasDeleteAction(): bool
    {
        return false;
    }

    protected function hasEditAction(): bool
    {
        return true;
    }

    protected function hasViewAction(): bool
    {
        return false;
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }

    // CUSTOMIZE ICON OF EACH RECORD, CAN DELETE
    // public function getTreeRecordIcon(?\Illuminate\Database\Eloquent\Model $record = null): ?string
    // {
    //     return null;
    // }
}
