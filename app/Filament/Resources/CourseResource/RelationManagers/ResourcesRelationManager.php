<?php

// app/Filament/Resources/CourseResource/RelationManagers/ResourcesRelationManager.php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ResourcesRelationManager extends RelationManager
{
    protected static string $relationship = 'resources';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('عنوان منبع'),

                Forms\Components\FileUpload::make('file_path')
                    ->required()
                    ->label('فایل')
                    ->directory('course/resources'),

                Forms\Components\Select::make('type')
                    ->options([
                        'pdf' => 'PDF',
                        'video' => 'ویدیو',
                        'audio' => 'صوت',
                        'document' => 'سند',
                        'archive' => 'آرشیو',
                    ])
                    ->default('pdf')
                    ->label('نوع فایل'),

                Forms\Components\Textarea::make('description')
                    ->columnSpanFull()
                    ->label('توضیحات'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان منبع'),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->label('نوع فایل'),

                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->label('توضیحات'),
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
