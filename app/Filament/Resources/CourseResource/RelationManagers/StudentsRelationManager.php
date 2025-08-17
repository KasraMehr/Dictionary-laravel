<?php

// app/Filament/Resources/CourseResource/RelationManagers/StudentsRelationManager.php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('users', 'name')
                    ->required()
                    ->label('دانشجو'),

                Forms\Components\DateTimePicker::make('enrolled_at')
                    ->label('تاریخ ثبت‌نام'),

                Forms\Components\TextInput::make('progress')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->label('پیشرفت (%)'),

                Forms\Components\DateTimePicker::make('completed_at')
                    ->label('تاریخ تکمیل'),

                Forms\Components\TextInput::make('rating')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5)
                    ->label('امتیاز'),

                Forms\Components\Toggle::make('is_favorite')
                    ->label('علاقه‌مندی'),

                Forms\Components\Select::make('payment_status')
                    ->options([
                        'pending' => 'در انتظار',
                        'paid' => 'پرداخت شده',
                        'failed' => 'ناموفق',
                        'refunded' => 'عودت شده',
                    ])
                    ->label('وضعیت پرداخت'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('نام دانشجو'),

                Tables\Columns\TextColumn::make('pivot.enrolled_at')
                    ->dateTime()
                    ->label('تاریخ ثبت‌نام'),

                Tables\Columns\TextColumn::make('pivot.progress')
                    ->formatStateUsing(fn ($state) => $state . '%')
                    ->label('پیشرفت'),

                Tables\Columns\TextColumn::make('pivot.payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'failed' => 'danger',
                        'refunded' => 'info',
                    })
                    ->label('وضعیت پرداخت'),

                Tables\Columns\IconColumn::make('pivot.is_favorite')
                    ->boolean()
                    ->label('علاقه‌مندی'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\Select::make('payment_status')
                            ->options([
                                'pending' => 'در انتظار',
                                'paid' => 'پرداخت شده',
                                'failed' => 'ناموفق',
                                'refunded' => 'عودت شده',
                            ])
                            ->default('paid')
                            ->label('وضعیت پرداخت'),
                    ]),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
                Tables\Actions\EditAction::make()
                    ->form(fn (Forms\Form $form): Forms\Form => $form->schema($this->form($form)->getComponents())),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
