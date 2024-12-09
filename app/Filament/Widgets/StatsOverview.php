<?php

namespace App\Filament\Widgets;

use App\Models\Location;
use App\Models\Record;
use App\Models\Register;
use App\Models\Maintenance;
use App\Models\Report;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Locations', Location::count())
                ->description('Total locations')
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('success')
                ->url(route('filament.admin.resources.locations.index')),
                
            Stat::make('Record Barang', Record::count())
                ->description('Total records')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('info')
                ->url(route('filament.admin.resources.records.index')),
                
            Stat::make('Register Barang', Register::count())
                ->description('Total registers')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('warning')
                ->url(route('filament.admin.resources.registers.index')),
                
            Stat::make('Maintenance', Maintenance::count())
                ->description('Total maintenance')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('danger')
                ->url(route('filament.admin.resources.maintenances.index')),
                
            Stat::make('Reports', Report::count())
                ->description('Total reports')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary')
                ->url(route('filament.admin.resources.reports.index')),
        ];
    }
}