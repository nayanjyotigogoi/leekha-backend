<?php

namespace App\Filament\Resources\ReadersWallResource\Pages;

use App\Filament\Resources\ReadersWallResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReadersWall extends EditRecord
{
    protected static string $resource = ReadersWallResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
