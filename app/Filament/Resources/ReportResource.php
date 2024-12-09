<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Models\Report;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use Carbon\Carbon;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
        
            ->schema([
                Forms\Components\Select::make('filter_type')
                    ->label('Jenis Filter')
                    ->options([
                        'date_range' => 'Rentang Tanggal',
                        'quarter' => 'Quarter',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($set) {
                        $set('start_date', null);
                        $set('end_date', null);
                        $set('quarter', null);
                    })
                    ->afterStateUpdated(fn (callable $set) => $set('quarter', null)),
                Forms\Components\DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->required()
                    ->visible(fn (callable $get) => $get('filter_type') === 'date_range'),
                Forms\Components\DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->required()
                    ->visible(fn (callable $get) => $get('filter_type') === 'date_range'),
                Forms\Components\Select::make('quarter')
                    ->label('Quarter')
                    ->options([
                        'Q1' => 'Q1 (January-March)',
                        'Q2' => 'Q2 (April-June)',
                        'Q3' => 'Q3 (July-September)',
                        'Q4' => 'Q4 (October-December)',
                    ])
                    ->required()
                    ->visible(fn (callable $get) => $get('filter_type') === 'quarter'),

                Forms\Components\Select::make('report_type')
                    ->label('Jenis Laporan')
                    ->options([
                        'register_barang' => 'Register Barang',
                        'record_barang' => 'Record Barang',
                        'maintenance' => 'Maintenance',
                    ])
                    
                ]);
            
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('filter_type')
                    ->label('Jenis Filter'),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tanggal Mulai')
                    ->date()
                    ->formatStateUsing(fn ($state, $record) => $record->filter_type === 'quarter' ? '-' : $state),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tanggal Selesai')
                    ->date()
                    ->formatStateUsing(fn ($state, $record) => $record->filter_type === 'quarter' ? '-' : $state),
                Tables\Columns\TextColumn::make('quarter')
                    ->label('Quarter')
                    ->formatStateUsing(fn ($state, $record) => $record->filter_type === 'date_range' ? '-' : $state),
                Tables\Columns\TextColumn::make('report_type')
                    ->label('Jenis Laporan'),
            ])
            ->actions([
                Action::make('download_pdf')
                    ->label('Download PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->button()
                    ->color('success')
                    ->url(fn (Report $record) => route('reports.download-pdf', [
                        'filter_type' => $record->filter_type,
                        'start_date' => $record->start_date,
                        'end_date' => $record->end_date,
                        'quarter' => $record->quarter,
                        'report_type' => $record->report_type,
                    ]))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'view' => Pages\ViewReport::route('/{record}'),
        ];
    }
}
