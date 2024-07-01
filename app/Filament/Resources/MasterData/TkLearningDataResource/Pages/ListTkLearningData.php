<?php

namespace App\Filament\Resources\MasterData\TkLearningDataResource\Pages;

use Filament\Actions;
use App\Helpers\Helper;
use App\Models\TkTopic;
use Filament\Forms\Get;
use App\Models\ClassSchool;
use App\Models\TkLearningData;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MasterData\TkLearningDataResource;

class ListTkLearningData extends ListRecords
{
    protected static string $resource = TkLearningDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Actions\Action::make('generate')
                ->label('Generate Learning Data')
                ->action(function (array $data) {
                    $levelId = $data['level_id'] ?? null;
                    $classSchoolId = $data['class_school_id'] ?? null;

                    if ($levelId && $classSchoolId) {
                        $topics = TkTopic::whereHas('element', function (Builder $query) use ($levelId) {
                            $query->where('level_id', $levelId);
                        })->get();

                        foreach ($topics as $topic) {
                            // Find the existing record
                            $existingRecord = TkLearningData::where([
                                'tk_topic_id' => $topic->id,
                                'class_school_id' => $classSchoolId,
                                'level_id' => $levelId,
                            ])->first();

                            // Preserve the current teacher_id if it exists
                            $teacherId = $existingRecord ? $existingRecord->teacher_id : null;

                            TkLearningData::updateOrCreate(
                                [
                                    'tk_topic_id' => $topic->id,
                                    'class_school_id' => $classSchoolId,
                                    'level_id' => $levelId,
                                ],
                                [
                                    'teacher_id' => $teacherId,
                                ]
                            );
                        }

                        Notification::make()
                            ->success()
                            ->title('Learning Data Generated')
                            ->send();
                    }
                })
                ->form([
                    Select::make('level_id')
                        ->label('Level')
                        ->relationship('level', 'name', function ($query) {
                            $query->whereIn('id', [1, 2, 3])->orderBy('id', 'asc');
                        })
                        ->searchable()
                        ->live()
                        ->preload()
                        ->required(),

                    Select::make('class_school_id')
                        ->label('Class School')
                        ->relationship('classSchool', 'name', function ($query, $get) {
                            $activeAcademicYearId = Helper::getActiveAcademicYearId();
                            $levelId = $get('level_id');
                            $query->where('academic_year_id', $activeAcademicYearId)
                                ->whereHas('level', function ($query) use ($levelId) {
                                    $query->where('id', $levelId)->orderBy('id', 'asc');
                                });
                        })
                        ->searchable()
                        ->preload()
                        ->required(),
                ])
                ->requiresConfirmation()
                ->modalHeading('Generate Learning Data')
                ->modalButton('Generate'),
        ];
    }
}
