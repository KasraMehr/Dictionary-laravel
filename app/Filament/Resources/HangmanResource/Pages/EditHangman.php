<?php

namespace App\Filament\Resources\HangmanResource\Pages;

use App\Filament\Resources\HangmanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHangman extends EditRecord
{
    protected static string $resource = HangmanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
