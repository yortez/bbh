<?php

namespace App\Filament\Resources\BoardersResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'invoice';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('invoice_date')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('invoice_date')
            ->columns([
                Tables\Columns\TextColumn::make('invoice_date')
                    ->date('Y-m-d'),
                Tables\Columns\TextColumn::make('amount'),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),

            ]);
    }
}
