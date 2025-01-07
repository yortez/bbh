<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoardersResource\Pages;
use App\Filament\Resources\BoardersResource\RelationManagers;
use App\Filament\Resources\BoardersResource\RelationManagers\InvoicesRelationManager;
use App\Models\Boarders;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
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

                Group::make([
                    Section::make('Personal Information')->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('age')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('gender')
                            ->required(),
                        Forms\Components\TextInput::make('course'),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->required(),
                        Forms\Components\Textarea::make('address')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),
                    Section::make('Emergency Contact')->schema([
                        Forms\Components\TextInput::make('contact_person')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('contact_person_phone')
                            ->tel()
                            ->required(),
                        Forms\Components\TextInput::make('relation')
                            ->required(),
                    ])->columns(2),

                ])->columnSpan(2),
                Group::make([
                    Section::make('Room Information')->schema([
                        Forms\Components\DatePicker::make('check_in')
                            ->required(),
                        Forms\Components\Select::make('room_id')
                            ->relationship('room', 'number')
                            ->required(),
                        Forms\Components\Toggle::make('staus'),

                    ]),

                ])->columnSpan(1),


            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('room.number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('check_in')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('gender')
                    ->searchable(),
                Tables\Columns\TextColumn::make('course')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('balance')
                    ->numeric()
                    ->sortable(),
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
                    Tables\Actions\DeleteAction::make(),
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
