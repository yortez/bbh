<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'New' => Tab::make('New')
                ->modifyQueryUsing(fn($query) => $query->where('status', 'New')),
            'Paid' => Tab::make('Paid')
                ->modifyQueryUsing(fn($query) => $query->where('status', 'Paid')),
            'Partial' => Tab::make('Partial')
                ->modifyQueryUsing(fn($query) => $query->where('status', 'Partial')),

            'Due' => Tab::make('Due')
                ->modifyQueryUsing(fn($query) => $query->where('status', 'Due')),
            'all' => Tab::make('All'),

        ];
    }
}
