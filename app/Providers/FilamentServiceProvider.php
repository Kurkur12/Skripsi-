<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            // Customize Filament here
            // Add a custom navigation item with a link to the dashboard
            Filament::registerNavigationItems([
                NavigationItem::make('Dashboard')
                    ->url(Filament::getUrl()) // Use the base admin panel URL
                    ->icon('heroicon-o-home')
                    ->activeIcon('heroicon-s-home')
                    ->isActiveWhen(fn (): bool => request()->url() === Filament::getUrl())
                    ->sort(1),
            ]);

            // Or add a navigation group:
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                     ->label('Settings')
                     ->icon('heroicon-o-cog')
                     ->collapsed(),
            ]);
        });
    }
}