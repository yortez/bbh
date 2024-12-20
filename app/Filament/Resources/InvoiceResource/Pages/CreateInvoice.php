<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Boarder;
use App\Models\Boarders;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Update boarder's balance
        $this->updateBoarderBalance($data);

        return $data;
    }

    protected function updateBoarderBalance(array $data): void
    {
        // Get the boarder associated with this invoice
        $boarder = Boarders::find($data['boarders_id']);

        if ($boarder) {
            // Increase the boarder's balance by the invoice amount
            $boarder->balance += $data['amount'];
            $boarder->save();
        }
    }
}
