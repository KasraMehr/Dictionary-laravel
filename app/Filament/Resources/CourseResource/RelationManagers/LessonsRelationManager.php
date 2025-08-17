<?php

// app/Filament/Resources/CourseResource/RelationManagers/LessonsRelationManager.php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'course_lessons';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('عنوان درس'),

                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull()
                    ->label('توضیحات'),

                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0)
                    ->label('ترتیب'),

                Forms\Components\TextInput::make('duration_minutes')
                    ->numeric()
                    ->label('مدت زمان (دقیقه)'),

                Forms\Components\Toggle::make('is_preview')
                    ->label('پیش‌نمایش رایگان'),

                Forms\Components\FileUpload::make('video_url')
                    ->label('ویدیو')
                    ->directory('lessons/videos'),

                Forms\Components\FileUpload::make('thumbnail')
                    ->image()
                    ->directory('lessons/thumbnails')
                    ->label('تصویر شاخص'),

                Forms\Components\FileUpload::make('attachments')
                    ->multiple()
                    ->directory('lessons/attachments')
                    ->label('فایل‌های ضمیمه'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان درس'),

                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->label('ترتیب'),

                Tables\Columns\TextColumn::make('duration_minutes')
                    ->formatStateUsing(fn ($state) => $state . ' دقیقه')
                    ->label('مدت زمان'),

                Tables\Columns\IconColumn::make('is_preview')
                    ->boolean()
                    ->label('پیش‌نمایش'),
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
