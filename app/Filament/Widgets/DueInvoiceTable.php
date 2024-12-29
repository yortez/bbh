<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class DueInvoiceTable extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->heading('Unpaid Rents')
            ->query(
                Invoice::query()
                    // ->where('due_date', '<=', now())
                    ->where('status', '==', 'Due')
            )
            ->columns([
                Tables\Columns\TextColumn::make('invoice_date')
                    ->label('Date')
                    ->date('F j, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('boarders.name')
                    ->label('Boarder')
                    ->sortable(),
                Tables\Columns\TextColumn::make('boarders.room.number'),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Total Amount')
                    ->money('php')
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date('F j, Y')
                    ->sortable(),
            ]);
    }
}
