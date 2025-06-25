<?php

namespace App\Filament\Resources\WordleResource\Pages;

use App\Filament\Resources\WordleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWordle extends EditRecord
{
    protected static string $resource = WordleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
