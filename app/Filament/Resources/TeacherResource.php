<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $modelLabel = 'معلم';

    protected static ?string $pluralModelLabel = 'معلم‌ها';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->label('کاربر'),

                Forms\Components\TextInput::make('title')
                    ->label('عنوان')
                    ->maxLength(255),

                Forms\Components\Textarea::make('bio')
                    ->label('بیوگرافی')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('profile_photo_path')
                    ->label('عکس پروفایل')
                    ->directory('teacher-profiles')
                    ->image()
                    ->imageEditor(),

                Forms\Components\TagsInput::make('languages')
                    ->label('زبان‌ها')
                    ->separator(','),

                Forms\Components\Repeater::make('experiences')
                    ->label('تجربیات')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('عنوان')
                            ->required(),
                        Forms\Components\TextInput::make('company')
                            ->label('شرکت/موسسه'),
                        Forms\Components\DatePicker::make('start_date')
                            ->label('تاریخ شروع'),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('تاریخ پایان'),
                        Forms\Components\Toggle::make('current')
                            ->label('هم اکنون'),
                        Forms\Components\Textarea::make('description')
                            ->label('توضیحات'),
                    ])
                    ->columnSpanFull(),

                Forms\Components\Repeater::make('social_links')
                    ->label('شبکه‌های اجتماعی')
                    ->schema([
                        Forms\Components\Select::make('platform')
                            ->label('پلتفرم')
                            ->options([
                                'twitter' => 'Twitter',
                                'facebook' => 'Facebook',
                                'instagram' => 'Instagram',
                                'linkedin' => 'LinkedIn',
                                'youtube' => 'YouTube',
                                'website' => 'Website',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('url')
                            ->label('لینک')
                            ->url()
                            ->required(),
                    ])
                    ->columnSpanFull(),

                Forms\Components\TagsInput::make('teaching_methods')
                    ->label('روش‌های تدریس')
                    ->separator(','),

                Forms\Components\TextInput::make('phone')
                    ->label('تلفن')
                    ->tel()
                    ->maxLength(20),

                Forms\Components\TextInput::make('website')
                    ->label('وبسایت')
                    ->url()
                    ->maxLength(255),

                Forms\Components\TextInput::make('location')
                    ->label('موقعیت جغرافیایی')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('نام')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('تلفن')
                    ->searchable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('موقعیت')
                    ->searchable(),
                Tables\Columns\TextColumn::make('students_count')
                    ->label('تعداد دانشجویان')
                    ->counts('students') // از counts برای شمارش استفاده می‌کنیم
                    ->sortable(),

                // تعداد دوره‌ها
                Tables\Columns\TextColumn::make('courses_count')
                    ->label('تعداد دوره‌ها')
                    ->counts('courses') // از counts برای شمارش استفاده می‌کنیم
                    ->sortable(),
            ])
            ->filters([
                //
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
            RelationManagers\CoursesRelationManager::class,
            RelationManagers\StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
//            'view' => Pages\ViewTeacher::route('/{record}'),
        ];
    }
}
