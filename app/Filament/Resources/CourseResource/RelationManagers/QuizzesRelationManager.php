<?php

// app/Filament/Resources/CourseResource/RelationManagers/QuizzesRelationManager.php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizzesRelationManager extends RelationManager
{
    protected static string $relationship = 'quizzes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('عنوان آزمون'),

                Forms\Components\Select::make('type')
                    ->options([
                        'lesson' => 'آزمون درس',
                        'final' => 'آزمون پایانی',
                        'placement' => 'آزمون تعیین سطح',
                    ])
                    ->required()
                    ->label('نوع آزمون'),

                Forms\Components\TextInput::make('time_limit')
                    ->numeric()
                    ->label('زمان محدود (دقیقه)'),

                Forms\Components\TextInput::make('pass_score')
                    ->numeric()
                    ->default(70)
                    ->label('نمره قبولی'),

                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'فعال',
                        'inactive' => 'غیرفعال',
                    ])
                    ->default('active')
                    ->label('وضعیت'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان آزمون'),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'lesson' => 'info',
                        'final' => 'success',
                        'placement' => 'warning',
                    })
                    ->label('نوع آزمون'),

                Tables\Columns\TextColumn::make('time_limit')
                    ->formatStateUsing(fn ($state) => $state ? $state . ' دقیقه' : 'نامحدود')
                    ->label('زمان'),

                Tables\Columns\TextColumn::make('pass_score')
                    ->formatStateUsing(fn ($state) => $state . '%')
                    ->label('نمره قبولی'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                    })
                    ->label('وضعیت'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
