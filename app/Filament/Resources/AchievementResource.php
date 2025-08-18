<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AchievementResource\Pages;
use App\Models\Achievement;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AchievementResource extends Resource
{
    protected static ?string $model = Achievement::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationLabel = 'Achievements';

    protected static ?string $pluralModelLabel = 'Achievements';

    protected static ?string $navigationGroup = 'Courses';

    protected static ?string $modelLabel = 'Achievement';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required(),
                Textarea::make('description'),
                Select::make('type')
                    ->options([
                        'grammar' => 'Grammar',
                        'topic' => 'Topic',
                        'level' => 'Level',
                        'custom' => 'Custom',
                    ])
                    ->required(),
                FileUpload::make('icon')
                    ->label('Badge Icon')
                    ->directory('achievements/icons')
                    ->image()
                    ->imageEditor()
                    ->imagePreviewHeight('100')
                    ->columnSpanFull()
                    ->hint('Upload a small badge image (e.g. PNG, JPG, SVG)'),
                TextInput::make('goal')->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('icon')
                    ->label('Icon')
                    ->circular()
                    ->height(40)
                    ->width(40),
                TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50),

                BadgeColumn::make('type')
                    ->label('Type')
                    ->colors([
                        'primary' => 'grammar',
                        'info' => 'topic',
                        'success' => 'level',
                        'warning' => 'custom',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                TextColumn::make('goal')
                    ->label('Goal')
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAchievements::route('/'),
            'create' => Pages\CreateAchievement::route('/create'),
            'edit' => Pages\EditAchievement::route('/{record}/edit'),
        ];
    }
}
