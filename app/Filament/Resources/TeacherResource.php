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

    protected static ?string $modelLabel = 'Teacher';

    protected static ?string $navigationGroup = 'Users';

    protected static ?string $pluralModelLabel = 'Teachers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->label('User Account [Required]')
                    ->hint('Select associated user'),

                Forms\Components\TextInput::make('title')
                    ->label('Professional Title')
                    ->maxLength(255)
                    ->hint('e.g., Professor, Instructor'),

                Forms\Components\Textarea::make('bio')
                    ->label('Biography')
                    ->columnSpanFull()
                    ->hint('Professional background and qualifications'),

                Forms\Components\FileUpload::make('profile_photo_path')
                    ->label('Profile Photo')
                    ->directory('teacher-profiles')
                    ->image()
                    ->imageEditor()
                    ->hint('Recommended size: 500x500px'),

                Forms\Components\TagsInput::make('languages')
                    ->label('Languages Spoken')
                    ->separator(',')
                    ->hint('Separate with commas'),

                Forms\Components\Repeater::make('experiences')
                    ->label('Professional Experience')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Position Title')
                            ->required(),
                        Forms\Components\TextInput::make('company')
                            ->label('Institution/Organization'),
                        Forms\Components\DatePicker::make('start_date')
                            ->label('Start Date'),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('End Date'),
                        Forms\Components\Toggle::make('current')
                            ->label('Current Position'),
                        Forms\Components\Textarea::make('description')
                            ->label('Responsibilities'),
                    ])
                    ->columnSpanFull()
                    ->hint('Add relevant work history'),

                Forms\Components\Repeater::make('social_links')
                    ->label('Social Media Profiles')
                    ->schema([
                        Forms\Components\Select::make('platform')
                            ->label('Platform')
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
                            ->label('Profile URL')
                            ->url()
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->hint('Add professional social media links'),

                Forms\Components\TagsInput::make('teaching_methods')
                    ->label('Teaching Methods')
                    ->separator(',')
                    ->hint('e.g., Flipped Classroom, Project-Based'),

                Forms\Components\TextInput::make('phone')
                    ->label('Contact Number')
                    ->tel()
                    ->maxLength(20),

                Forms\Components\TextInput::make('website')
                    ->label('Personal Website')
                    ->url()
                    ->maxLength(255),

                Forms\Components\TextInput::make('location')
                    ->label('Geographic Location')
                    ->maxLength(255)
                    ->hint('City, Country'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile_photo_path')
                    ->label('Photo')
                    ->circular(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('Location')
                    ->searchable(),

                Tables\Columns\TextColumn::make('students_count')
                    ->label('Students')
                    ->counts('students')
                    ->sortable()
                    ->icon('heroicon-o-user-group'),

                Tables\Columns\TextColumn::make('courses_count')
                    ->label('Courses')
                    ->counts('courses')
                    ->sortable()
                    ->icon('heroicon-o-book-open'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('languages')
                    ->label('Languages')
                    ->options([])
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil'),
                Tables\Actions\ViewAction::make()
                    ->icon('heroicon-o-eye'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->icon('heroicon-o-trash'),
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
        ];
    }
}
