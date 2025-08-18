<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HangmanResource\Pages;
use App\Filament\Resources\HangmanResource\RelationManagers;
use App\Models\Hangman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HangmanResource extends Resource
{
    protected static ?string $model = Hangman::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    protected static ?string $navigationGroup = 'Games';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('word')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              TextColumn::make('word')
                  ->label('Word')
                  ->sortable()
                  ->searchable(),
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
            ]);
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
            'index' => Pages\ListHangmen::route('/'),
            'create' => Pages\CreateHangman::route('/create'),
            'edit' => Pages\EditHangman::route('/{record}/edit'),
        ];
    }
}
