<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaintenanceResource\Pages;
use App\Models\Maintenance;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rule;

class MaintenanceResource extends Resource
{
    protected static ?string $model = Maintenance::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_barang')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Kode barang sudah digunakan.',
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
                    ->type('number'),
                Forms\Components\DatePicker::make('tanggal_maintenance')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_maintenance_selanjutnya')
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_barang'),
                Tables\Columns\TextColumn::make('nama_barang'),
                Tables\Columns\TextColumn::make('kondisi')
                    ->label('Kondisi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Baik' => 'success',
                        'Rusak Ringan' => 'warning',
                        'Rusak Berat' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('jumlah'),
                Tables\Columns\TextColumn::make('tanggal_maintenance')
                    ->date('Y-m-d'),
                Tables\Columns\TextColumn::make('tanggal_maintenance_selanjutnya')
                    ->date('Y-m-d'),
            ])
            ->filters([
                SelectFilter::make('kondisi')
                    ->options([
                        'Baik' => 'Baik',
                        'Rusak Ringan' => 'Rusak Ringan',
                        'Rusak Berat' => 'Rusak Berat'
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMaintenances::route('/'),
            'create' => Pages\CreateMaintenance::route('/create'),
            'edit' => Pages\EditMaintenance::route('/{record}/edit'),
        ];
    }    
}