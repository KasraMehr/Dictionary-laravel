<?php

namespace App\Filament\Resources\HangmanResource\Pages;

use App\Filament\Resources\HangmanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHangmen extends ListRecords
{
    protected static string $resource = HangmanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
