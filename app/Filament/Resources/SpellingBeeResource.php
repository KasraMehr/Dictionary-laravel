<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpellingBeeResource\Pages;
use App\Filament\Resources\SpellingBeeResource\RelationManagers;
use App\Models\SpellingBee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
// use Filament\Tables\Columns\ArrayColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpellingBeeResource extends Resource
{
    protected static ?string $model = SpellingBee::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationGroup = 'Games';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              TextInput::make('word')->required(),
              TextInput::make('answers')->required()->json(),
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
              TextColumn::make('answers')
                  ->label('Answers')
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
            'index' => Pages\ListSpellingBees::route('/'),
            'create' => Pages\CreateSpellingBee::route('/create'),
            'edit' => Pages\EditSpellingBee::route('/{record}/edit'),
        ];
    }
}
