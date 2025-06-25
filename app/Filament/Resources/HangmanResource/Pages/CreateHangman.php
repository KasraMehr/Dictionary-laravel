<?php

namespace App\Filament\Resources\HangmanResource\Pages;

use App\Filament\Resources\HangmanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHangman extends CreateRecord
{
    protected static string $resource = HangmanResource::class;
}
