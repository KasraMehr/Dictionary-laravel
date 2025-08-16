<?php

namespace App\Filament\Resources\TeacherResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    protected static ?string $title = 'دانشجویان';

    protected static ?string $modelLabel = 'دانشجو';

    protected static ?string $pluralModelLabel = 'دانشجویان';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->relationship('student', 'name')
                    ->label('دانشجو')
                    ->required(),

                Forms\Components\Select::make('level')
                    ->label('سطح')
                    ->options([
                        'beginner' => 'مبتدی',
                        'intermediate' => 'متوسط',
                        'advanced' => 'پیشرفته',
                    ])
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->label('یادداشت‌ها'),

                Forms\Components\Select::make('status')
                    ->label('وضعیت')
                    ->options([
                        'active' => 'فعال',
                        'paused' => 'متوقف',
                        'completed' => 'تکمیل شده',
                    ])
                    ->required(),

                Forms\Components\DatePicker::make('start_date')
                    ->label('تاریخ شروع'),

                Forms\Components\DatePicker::make('end_date')
                    ->label('تاریخ پایان'),

                Forms\Components\TextInput::make('total_sessions')
                    ->label('تعداد جلسات')
                    ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->label('نام دانشجو')
                    ->searchable(),

                Tables\Columns\TextColumn::make('level')
                    ->label('سطح')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'beginner' => 'gray',
                        'intermediate' => 'info',
                        'advanced' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'paused' => 'warning',
                        'completed' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('تاریخ شروع')
                    ->date(),

                Tables\Columns\TextColumn::make('total_sessions')
                    ->label('جلسات'),
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
