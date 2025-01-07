<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Actions\ActionGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'New')->count();
    }
    protected static ?string $navigationBadgeTooltip = 'New Invoices';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('boarders_id')
                    ->relationship('boarders', 'name')
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('invoice_date')
                    ->required()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {
                            $dueDate = date('Y-m-d', strtotime($state . ' + 7 days'));
                            $set('due_date', $dueDate);
                        }
                    }),
                Forms\Components\DatePicker::make('due_date')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'New' => 'New',
                        'Paid' => 'Paid',
                        'Partial' => 'Partial',
                        'Due' => 'Due',
                    ])
                    ->required(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('boarders.name')
                    ->numeric(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Paid' => 'success',
                        'Due' => 'danger',
                        default => 'warning',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Action::make('processPayment')
                        ->icon('heroicon-o-banknotes')
                        ->label('Process Payment')
                        ->form([
                            Forms\Components\TextInput::make('payment_amount')
                                ->required()
                                ->numeric()
                                ->label('Payment Amount'),
                        ])
                        ->action(function (Invoice $record, array $data) {
                            DB::transaction(function () use ($record, $data) {
                                $paymentAmount = $data['payment_amount'];
                                $remainingAmount = $record->amount - $paymentAmount;

                                // Update invoice status
                                if ($remainingAmount <= 0) {
                                    $record->status = 'Paid';
                                } else {
                                    $record->status = 'Partial';
                                }

                                $record->amount = max(0, $remainingAmount);
                                $record->save();

                                // Update boarder's balance
                                $boarder = $record->boarders;
                                $boarder->balance -= $paymentAmount;
                                $boarder->save();
                            });
                        })
                ])



            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
