<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TeachersRelationManager extends RelationManager
{
    protected static string $relationship = 'teachers';

    protected static ?string $title = 'معلمان مرتبط';

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
                Tables\Columns\TextColumn::make('name')
                    ->label('نام معلم'),

                Tables\Columns\TextColumn::make('pivot.level')
                    ->label('سطح آموزشی')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'beginner' => 'مبتدی',
                        'intermediate' => 'متوسط',
                        'advanced' => 'پیشرفته',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('pivot.status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'paused' => 'warning',
                        'completed' => 'gray',
                        default => 'primary',
                    }),

                Tables\Columns\TextColumn::make('pivot.start_date')
                    ->label('تاریخ شروع')
                    ->date(),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                // بررسی وجود رابطه
                if (method_exists($query->getModel(), 'teachers')) {
                    return $query->with('teachers');
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
