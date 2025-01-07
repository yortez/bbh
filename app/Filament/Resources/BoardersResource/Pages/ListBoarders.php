<?php

namespace App\Filament\Resources\BoardersResource\Pages;

use App\Filament\Resources\BoardersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBoarders extends ListRecords
{
    protected static string $resource = BoardersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
