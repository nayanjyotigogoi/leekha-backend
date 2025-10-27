<?php

namespace App\Filament\Resources\WritingResource\Pages;

use App\Filament\Resources\WritingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWriting extends EditRecord
{
    protected static string $resource = WritingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
