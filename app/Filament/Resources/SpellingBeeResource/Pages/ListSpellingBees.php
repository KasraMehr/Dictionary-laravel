<?php

namespace App\Filament\Resources\SpellingBeeResource\Pages;

use App\Filament\Resources\SpellingBeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSpellingBees extends ListRecords
{
    protected static string $resource = SpellingBeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
