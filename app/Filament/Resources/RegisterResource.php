<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegisterResource\Pages;
use App\Filament\Resources\RegisterResource\RelationManagers;
use App\Models\Register;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\QueryException;
use Filament\Notifications\Notification;

class RegisterResource extends Resource
{
    protected static ?string $model = Register::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    
    protected static ?string $navigationLabel = 'Register Barang';

    protected static ?string $modelLabel = 'Register';

    protected static ?string $pluralModelLabel = 'Register';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(255)
                            ->label('Kode Barang')
                            ->placeholder('Masukkan kode barang')
                            ->unique(ignorable: fn ($record) => $record)
                            ->rules(['required', 'max:255'])
                            ->afterStateUpdated(function (string $state, Forms\Set $set) {
                                $set('code', strtoupper($state));
                            })
                            ->helperText('Kode barang harus unik'),

                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Barang')
                            ->placeholder('Masukkan nama barang'),

                        Forms\Components\Select::make('condition')
                            ->required()
                            ->options([
                                'Baik' => 'Baik',
                                'Rusak Ringan' => 'Rusak Ringan',
                                'Rusak Berat' => 'Rusak Berat'
                            ])
                            ->label('Kondisi')
                            ->placeholder('Pilih kondisi barang'),

                        Forms\Components\TextInput::make('quantity')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->label('Jumlah')
                            ->placeholder('Masukkan jumlah barang'),

                        Forms\Components\DatePicker::make('date_of_entry')
                            ->required()
                            ->label('Tanggal Masuk')
                            ->default(now())
                            ->maxDate(now()),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode ')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Kode barang berhasil disalin')
                    ->copyMessageDuration(1500),
                    
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('condition')
                    ->label('Kondisi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Baik' => 'success',
                        'Rusak Ringan' => 'warning',
                        'Rusak Berat' => 'danger',
                        default => 'gray',
                    }),
                    
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Jumlah')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('date_of_entry')
                    ->label('Tanggal Masuk')
                    ->date('d F Y')
                    ->sortable(),
                    

            ])
            ->filters([
                SelectFilter::make('condition')
                    ->label('Kondisi')
                    ->options([
                        'Baik' => 'Baik',
                        'Rusak Ringan' => 'Rusak Ringan',
                        'Rusak Berat' => 'Rusak Berat'
                    ]),
                    
                Filter::make('date_of_entry')
                    ->form([
                        Forms\Components\DatePicker::make('date_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('date_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date_of_entry', '>=', $date),
                            )
                            ->when(
                                $data['date_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date_of_entry', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListRegisters::route('/'),
            'create' => Pages\CreateRegister::route('/create'),
            'edit' => Pages\EditRegister::route('/{record}/edit'),
        ];
    }
}