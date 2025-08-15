<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CoursesRelationManager extends RelationManager
{
    protected static string $relationship = 'courses';

    protected static ?string $title = 'دوره‌های ثبت‌نام شده';

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
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان دوره'),

                Tables\Columns\TextColumn::make('pivot.progress')
                    ->label('پیشرفت')
                    ->suffix('%'),

                Tables\Columns\TextColumn::make('pivot.enrolled_at')
                    ->label('تاریخ ثبت‌نام')
                    ->dateTime(),

                Tables\Columns\IconColumn::make('pivot.is_favorite')
                    ->label('مورد علاقه')
                    ->boolean(),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                // فقط برای روابط ManyToMany
                if (method_exists($query->getModel(), 'courses')) {
                    return $query->with('courses');
                }
                return $query;
            })
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
