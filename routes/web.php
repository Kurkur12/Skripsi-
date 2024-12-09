<?php
use App\Filament\Resources\RecordResource\Pages\ListRecords;
use App\Filament\Resources\RecordResource\Pages\CreateRecord;
use App\Filament\Resources\RecordResource\Pages\EditRecord;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/get-records', [HomeController::class, 'getRecords']);
Route::get('/get-maintenance', [HomeController::class, 'getMaintenance']);
Route::get('/get-locations', [HomeController::class, 'getLocations']);
Route::get('/location/{id}', [HomeController::class, 'viewLocation'])->name('location.view');
Route::get('/location/{id}/items', [LocationController::class, 'items']);
Route::get('/location/{id}/records', [LocationController::class, 'records']);
Route::get('/location/{id}/maintenance', [LocationController::class, 'maintenance']);
Route::post('/generate-report', [ReportController::class, 'generateReport'])->name('generate.report');
Route::get('/reports/download-pdf', [ReportController::class, 'generateReport'])->name('reports.download-pdf');
Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
Route::post('/maintenance', [MaintenanceController::class, 'store'])->name('maintenance.store');
Route::resource('record', RecordController::class);
Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);
Route::prefix('records')->group(function () {
Route::get('/', ListRecords::class)->name('records.index');
Route::get('/create', CreateRecord::class)->name('records.create');
Route::get('/{record}/edit', EditRecord::class)->name('records.edit');
});


