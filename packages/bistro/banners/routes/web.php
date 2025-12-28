<?php

use Illuminate\Support\Facades\Route;
use Bistro\Banners\Http\Controllers\BannerController;

// Banner Management Routes - standalone package routes
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::get('banners', [BannerController::class, 'index'])->name('banners');
    Route::post('banners', [BannerController::class, 'store'])->name('banners.store');
    Route::get('banners/create', [BannerController::class, 'create'])->name('banners.create');
    Route::get('banners/{banner}', [BannerController::class, 'show'])->name('banners.show');
    Route::get('banners/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit');
    Route::put('banners/{banner}', [BannerController::class, 'update'])->name('banners.update');
    Route::delete('banners/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');
    Route::patch('banners/{banner}/toggle', [BannerController::class, 'toggleStatus'])->name('banners.toggle');
});
