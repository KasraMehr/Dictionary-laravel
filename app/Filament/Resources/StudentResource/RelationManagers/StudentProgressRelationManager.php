<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentProgressRelationManager extends RelationManager
{
    protected static string $relationship = 'studentProgress';

    protected static ?string $title = 'پیشرفت آموزشی';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // غیرفعال کردن ویرایش
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('level')
                    ->label('سطح فعلی')
                    ->numeric(),

                Tables\Columns\TextColumn::make('xp')
                    ->label('امتیاز تجربه'),

                Tables\Columns\TextColumn::make('lessons_completed')
                    ->label('تعداد درس‌های تکمیل شده'),

                Tables\Columns\TextColumn::make('words_learned')
                    ->label('کلمات یادگرفته شده'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخرین بروزرسانی')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
