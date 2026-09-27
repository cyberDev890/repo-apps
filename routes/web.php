<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkUnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Only
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('categories', CategoryController::class)->except(['index', 'show']);
        Route::resource('devices', DeviceController::class)->except(['index', 'show']);
        Route::resource('documents', DocumentController::class)->except(['index', 'show']);
        Route::resource('work-units', WorkUnitController::class)->except(['index', 'show']);
        
        Route::get('/export/devices', [DeviceController::class, 'export'])->name('devices.export');
        Route::get('/export/documents', [DocumentController::class, 'export'])->name('documents.export');
    });

    // Shared View Access
    Route::get('/work-units', [WorkUnitController::class, 'index'])->name('work-units.index');
    Route::get('/work-units/search/autocomplete', [WorkUnitController::class, 'autocomplete'])->name('work-units.autocomplete');
    Route::get('/work-units/{work_unit}', [WorkUnitController::class, 'show'])->name('work-units.show');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/search/autocomplete', [CategoryController::class, 'autocomplete'])->name('categories.autocomplete');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    
    Route::get('/devices/network', [DeviceController::class, 'networkInventory'])->name('devices.network');
    Route::get('/devices/computers', [DeviceController::class, 'computerInventory'])->name('devices.computers');
    Route::get('/devices/laptops', [DeviceController::class, 'laptopInventory'])->name('devices.laptops');
    Route::get('/devices/printers', [DeviceController::class, 'printerInventory'])->name('devices.printers');
    Route::get('/devices/peripherals', [DeviceController::class, 'peripheralInventory'])->name('devices.peripherals');
    Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
    Route::get('/devices/search/autocomplete', [DeviceController::class, 'autocomplete'])->name('devices.autocomplete');
    Route::get('/devices/{device}', [DeviceController::class, 'show'])->name('devices.show');
    
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/search/autocomplete', [DocumentController::class, 'autocomplete'])->name('documents.autocomplete');
    Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
    Route::get('/documents/{document}/download-photo', [DocumentController::class, 'downloadPhoto'])->name('documents.downloadPhoto');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
