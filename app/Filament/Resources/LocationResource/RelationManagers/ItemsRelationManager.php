<?php

namespace App\Filament\Resources\LocationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';
    
    protected static ?string $title = 'Items';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_barang')
                    ->label('Kode barang')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_barang')
                    ->label('Nama barang')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kondisi')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_barang')
                    ->required()
                    ->maxLength(255),
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
            ]);
    }
}