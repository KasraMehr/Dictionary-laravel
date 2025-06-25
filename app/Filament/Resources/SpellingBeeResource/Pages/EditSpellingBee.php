<?php

namespace App\Filament\Resources\SpellingBeeResource\Pages;

use App\Filament\Resources\SpellingBeeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpellingBee extends EditRecord
{
    protected static string $resource = SpellingBeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
