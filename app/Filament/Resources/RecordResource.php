<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecordResource\Pages;
use App\Models\Record;
use App\Models\Register;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Illuminate\Validation\Rule;

class RecordResource extends Resource
{
    protected static ?string $model = Record::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = 'Record Barang';

    protected static ?string $modelLabel = 'Record';

    protected static ?string $pluralModelLabel = 'Records';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Select::make('code')
                            ->label('Kode Barang')
                            ->options(
                                Register::where('condition', 'Baik')
                                    ->pluck('code', 'code')
                            )
                            ->required()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $register = Register::where('code', $state)->first();
                                    if ($register) {
                                        $set('name', $register->name);
                                        $set('quantity', $register->quantity);
                                        $set('condition', 'Baik');
                                    } else {
                                        $set('name', null);
                                        $set('quantity', null);
                                        $set('condition', null);
                                    }
                                } else {
                                    $set('name', null);
                                    $set('quantity', null);
                                    $set('condition', null);
                                }
                            })
                            ->placeholder('Pilih kode barang')
                            ->unique(Record::class, 'code', fn ($record) => $record)
                            ->validationMessages([
                                'unique' => 'Kode barang sudah digunakan',
                            ]),
                            
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Barang')
                            ->required()
                            ->disabled()
                            ->dehydrated(true),
                        
                        Forms\Components\TextInput::make('condition')
                            ->label('Kondisi')
                            ->default('Baik')
                            ->required()
                            ->disabled()
                            ->dehydrated(true),
                            
                        Forms\Components\TextInput::make('quantity')
                            ->label('Jumlah')
                            ->required()
                            ->disabled()
                            ->dehydrated(true)
                            ->numeric(),

                        Forms\Components\DatePicker::make('date_of_entry')
                            ->label('Tanggal Masuk')
                            ->required()
                            ->default(now()->format('Y-m-d'))
                            ->maxDate(now())
                            ->displayFormat('d F Y'),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode Barang')
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
                   ->date('Y-m-d')
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
            'index' => Pages\ListRecords::route('/'),
            'create' => Pages\CreateRecord::route('/create'),
            'edit' => Pages\EditRecord::route('/{record}/edit'),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['date_of_entry'])) {
            $data['date_of_entry'] = date('Y-m-d', strtotime($data['date_of_entry']));
        }
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['date_of_entry'])) {
            $data['date_of_entry'] = date('Y-m-d', strtotime($data['date_of_entry']));
        }
        return $data;
    }
}