<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoardersResource\Pages;
use App\Filament\Resources\BoardersResource\RelationManagers;
use App\Filament\Resources\BoardersResource\RelationManagers\InvoicesRelationManager;
use App\Models\Boarders;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BoardersResource extends Resource
{
    protected static ?string $model = Boarders::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $recordTitleAttribute = 'name';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    protected static ?string $navigationBadgeTooltip = 'Total Boarders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('check_in')
                    ->required(),
                Forms\Components\Select::make('room_id')
                    ->relationship('room', 'number')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('number')
                            ->required(),
                        Forms\Components\TextInput::make('capacity')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('vacancy')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('rate')
                            ->numeric(),
                    ])
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('age')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'other' => 'Other',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('staus'),
                Forms\Components\TextInput::make('balance')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('check_in')
                    ->date('F j, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('room.number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('age')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->searchable(),
                Tables\Columns\TextColumn::make('balance')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('staus')
                    ->boolean(),
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

                ]),

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
            InvoicesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBoarders::route('/'),
            'create' => Pages\CreateBoarders::route('/create'),
            'edit' => Pages\EditBoarders::route('/{record}/edit'),
        ];
    }
}
