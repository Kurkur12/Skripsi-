<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\Pages;
use App\Filament\Resources\LocationResource\RelationManagers;
use App\Models\Location;
use App\Models\Record;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Repeater;
use Illuminate\Validation\Rule;
use Filament\Actions\Action;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_location')
                    ->required()
                    ->maxLength(255),
                Repeater::make('items')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('kode_barang')
                            ->required()
                            ->maxLength(255)
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                if ($state) {
                                    $record = Record::where('code', $state)->first();
                                    if ($record) {
                                        $set('nama_barang', $record->name);
                                        $set('kondisi', $record->condition);
                                        $set('jumlah', $record->quantity);
                                    } else {
                                        $set('nama_barang', null);
                                        $set('kondisi', null);
                                        $set('jumlah', null);
                                    }
                                }
                            })
                            ->unique(ignoreRecord: true)
                            ->rules([
                                function (Get $get) {
                                    return function (string $attribute, $value, \Closure $fail) use ($get) {
                                        $allKodeBrang = collect($get('../../items'))
                                            ->pluck('kode_barang')
                                            ->filter()
                                            ->values();

                                        if ($allKodeBrang->contains($value) && $allKodeBrang->countBy()->get($value) > 1) {
                                            $fail("Kode barang sudah digunakan.");
                                        }
                                    };
                                },
                            ]),
                        Forms\Components\TextInput::make('nama_barang')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('kondisi')
                            ->options([
                                'Baik' => 'Baik',
                                'Rusak Ringan' => 'Rusak Ringan',
                                'Rusak Berat' => 'Rusak Berat'
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('jumlah')
                            ->required()
                            ->numeric(),
                    ])
                    ->columns(1)
                    ->defaultItems(1)
                    ->createItemButtonLabel('Tambah Barang')
                    ->collapsible()
                    ->cloneable()
                    ->itemLabel(fn (array $state): ?string => $state['nama_barang'] ?? null)
                    ->reorderableWithButtons()
                    ->grid(2)
                    ->columnSpanFull()
                    ->extraAttributes(['class' => 'items-slider'])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('items_count')->counts('items')
                    ->label('Jumlah Barang'),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'view' => Pages\ViewLocation::route('/{record}'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }

    protected function getFormStyles(): string
    {
        return <<<CSS
        .items-slider {
            overflow-x: auto;
            white-space: nowrap;
            padding: 10px 0;
        }
        .items-slider > div {
            display: inline-block;
            vertical-align: top;
            margin-right: 10px;
            min-width: 300px;
        }
        CSS;
    }
}

