<?php

// app/Filament/Resources/CourseResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('اطلاعات پایه')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->label('عنوان دوره'),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->label('اسلاگ'),

                        Forms\Components\Select::make('created_by')
                            ->relationship('teacher', 'name')
                            ->required()
                            ->label('مدرس'),

                        Forms\Components\FileUpload::make('thumbnail')
                            ->image()
                            ->directory('courses/thumbnails')
                            ->label('تصویر شاخص'),

                        Forms\Components\TextInput::make('trailer_url')
                            ->maxLength(255)
                            ->label('لینک تریلر'),

                        Forms\Components\RichEditor::make('description')
                            ->columnSpanFull()
                            ->label('توضیحات'),
                    ])->columns(2),

                Forms\Components\Section::make('تنظیمات دوره')
                    ->schema([
                        Forms\Components\Select::make('level')
                            ->options([
                                'beginner' => 'مبتدی',
                                'intermediate' => 'متوسط',
                                'advanced' => 'پیشرفته',
                            ])
                            ->label('سطح'),

                        Forms\Components\Select::make('topic')
                            ->options([
                                'programming' => 'برنامه‌نویسی',
                                'design' => 'طراحی',
                                'business' => 'کسب و کار',
                            ])
                            ->label('موضوع'),

                        Forms\Components\Toggle::make('is_free')
                            ->label('رایگان'),

                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('$')
                            ->visible(fn (Forms\Get $get) => !$get('is_free'))
                            ->label('قیمت'),

                        Forms\Components\Select::make('language')
                            ->options([
                                'fa' => 'فارسی',
                                'en' => 'انگلیسی',
                            ])
                            ->label('زبان'),

                        Forms\Components\TextInput::make('duration_minutes')
                            ->numeric()
                            ->label('مدت زمان (دقیقه)'),

                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'پیش‌نویس',
                                'published' => 'منتشر شده',
                                'archived' => 'آرشیو شده',
                            ])
                            ->label('وضعیت'),
                    ])->columns(2),

                Forms\Components\Section::make('گواهینامه')
                    ->schema([
                        Forms\Components\FileUpload::make('certificate_template')
                            ->directory('courses/certificates')
                            ->label('تمپلیت گواهینامه'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('تصویر'),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('عنوان'),

                Tables\Columns\TextColumn::make('teacher.name')
                    ->sortable()
                    ->label('مدرس'),

                Tables\Columns\TextColumn::make('level')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'A1' => 'danger',
                        'A2' => 'danger',
                        'B1' => 'warning',
                        'B2' => 'warning',
                        'C1' => 'success',
                        'C2' => 'success',
                    })
                    ->label('سطح'),

                Tables\Columns\IconColumn::make('is_free')
                    ->boolean()
                    ->label('رایگان'),

                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->label('قیمت')
                    ->visible(fn (?Course $record): bool => $record ? !$record->is_free : false),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'archived' => 'danger',
                    })
                    ->label('وضعیت'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('تاریخ ایجاد'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'پیش‌نویس',
                        'published' => 'منتشر شده',
                        'archived' => 'آرشیو شده',
                    ])
                    ->label('وضعیت'),

                Tables\Filters\SelectFilter::make('level')
                    ->options([
                        'A1' => 'تازه کار',
                        'A2' => 'مبتدی',
                        'B1' => 'متوسط',
                        'B2' => 'خوب',
                        'C1' => 'خیلی خوب',
                        'C2' => 'پیشرفته',
                    ])
                    ->label('سطح'),

                Tables\Filters\SelectFilter::make('is_free')
                    ->options([
                        true => 'رایگان',
                        false => 'پولی',
                    ])
                    ->label('نوع دوره'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\LessonsRelationManager::class,
            RelationManagers\StudentsRelationManager::class,
            RelationManagers\ReviewsRelationManager::class,
            RelationManagers\QuizzesRelationManager::class,
            RelationManagers\ResourcesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
//            'view' => Pages\ViewCourse::route('/{record}'),
        ];
    }
}
