<?php

namespace App\Filament\Resources\BoardersResource\Pages;

use App\Filament\Resources\BoardersResource;
use App\Models\Room;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListBoarders extends ListRecords
{
    protected static string $resource = BoardersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [

            'active' => Tab::make('Current Boarders')
                ->modifyQueryUsing(fn($query) => $query->where('staus', 1))
                ->badge(fn() => $this->getResource()::getEloquentQuery()->where('staus', 1)->count()),
            'all' => Tab::make('All')
            // ->badge(fn() => $this->getResource()::getEloquentQuery()->count()),
        ];



        return $tabs;
    }
}
