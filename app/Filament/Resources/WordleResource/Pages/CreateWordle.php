<?php

namespace App\Filament\Resources\WordleResource\Pages;

use App\Filament\Resources\WordleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWordle extends CreateRecord
{
    protected static string $resource = WordleResource::class;
}
