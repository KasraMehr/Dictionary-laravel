<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $modelLabel = 'دانش آموز';

    protected static ?string $pluralModelLabel = 'دانش آموزان';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('اطلاعات پایه')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('نام کامل')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('ایمیل')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->label('رمز عبور')
                            ->password()
                            ->maxLength(255)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),
                    ]),

                Forms\Components\Section::make('پروفایل دانش آموزی')
                    ->relationship('studentProfile')
                    ->schema([
                        Forms\Components\Textarea::make('bio')
                            ->label('بیوگرافی')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('phone')
                            ->label('تلفن'),
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('تاریخ تولد'),
                        Forms\Components\TextInput::make('country')
                            ->label('کشور'),
                        // سایر فیلدهای پروفایل
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('نام')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('ایمیل')
                    ->searchable(),
                Tables\Columns\TextColumn::make('studentProgress.level')
                    ->label('سطح')
                    ->numeric(),
                Tables\Columns\TextColumn::make('courses_count')
                    ->label('دوره‌ها')
                    ->counts('courses'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('level')
                    ->label('سطح')
                    ->relationship('studentProgress', 'level'),
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
            RelationManagers\StudentProgressRelationManager::class,
            RelationManagers\TeachersRelationManager::class,
//            RelationManagers\LearningStatsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
            'view' => Pages\ViewStudent::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'student');
    }
}
