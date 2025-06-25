<?php

namespace App\Filament\Resources\WordleResource\Pages;

use App\Filament\Resources\WordleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWordles extends ListRecords
{
    protected static string $resource = WordleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
