<?php

namespace App\Filament\Resources\TeacherPgKg\TkAchivementGradeResource\Pages;

use Filament\Actions;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TeacherPgKg\TkAchivementGradeResource;

class CreateTkAchivementGrade extends CreateRecord
{
    protected static string $resource = TkAchivementGradeResource::class;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('member_class_school_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tk_point_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('term_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('achivement'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Define any filters if needed...
            ]);
    }
}
