<?php

namespace App\Filament\Resources\WritingResource\Pages;

use App\Filament\Resources\WritingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWritings extends ListRecords
{
    protected static string $resource = WritingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
