<?php

namespace App\Filament\Resources\RoomResource\Pages;

use App\Filament\Resources\RoomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListRooms extends ListRecords
{
    protected static string $resource = RoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'full' => Tab::make('Full ')
                ->modifyQueryUsing(fn($query) => $query->whereColumn('vacancy', '=', '0')),
            'vacant' => Tab::make('Vacants')
                ->modifyQueryUsing(fn($query) => $query->whereColumn('vacancy', '>', '0')),
        ];
    }
}
