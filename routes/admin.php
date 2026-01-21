<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuCategoryController;
use App\Http\Controllers\Admin\GSTSlabController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\ItemVariationTypeController;
use App\Http\Controllers\Admin\ItemVariationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\HomeLayoutController;
use App\Http\Controllers\Admin\HomeComponentOrderController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Login Routes
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Protected admin routes
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Order Management Routes
        Route::get('orders', [OrderController::class, 'index'])->name('orders');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::put('orders/{order}/payment-received', [OrderController::class, 'markPaymentReceived'])->name('orders.payment-received');
        Route::get('orders/{order}/print', [OrderController::class, 'printOrder'])->name('orders.print');
        Route::get('orders-export', [OrderController::class, 'exportOrders'])->name('orders.export');

        // Customer Management Routes
        Route::get('customers', [CustomerController::class, 'index'])->name('customers');

        Route::get('item-category', [MenuCategoryController::class, 'index'])->name('item-category');
        Route::post('item-category', [MenuCategoryController::class, 'store'])->name('item-category.store');
        Route::get('item-category/{itemCategory}', [MenuCategoryController::class, 'show'])->name('item-category.show');
        Route::put('item-category/{itemCategory}', [MenuCategoryController::class, 'update'])->name('item-category.update');
        Route::delete('item-category/{itemCategory}', [MenuCategoryController::class, 'destroy'])->name('item-category.destroy');
        
        Route::get('item-variation-types', [ItemVariationTypeController::class, 'index'])->name('item-variation-types');
        Route::post('item-variation-types', [ItemVariationTypeController::class, 'store'])->name('item-variation-types.store');
        Route::put('item-variation-types/{variationType}', [ItemVariationTypeController::class, 'update'])->name('item-variation-types.update');
        Route::delete('item-variation-types/{variationType}', [ItemVariationTypeController::class, 'destroy'])->name('item-variation-types.destroy');
        
        // Route::get('item-variations', [ItemVariationController::class, 'index'])->name('item-variations');
        // Route::post('item-variations', [ItemVariationController::class, 'store'])->name('item-variations.store');
        // Route::put('item-variations/{itemVariation}', [ItemVariationController::class, 'update'])->name('item-variations.update');
        Route::delete('item-variations/{itemVariation}', [ItemVariationController::class, 'destroy'])->name('item-variations.destroy');

        Route::delete('delete-item-image/{image}', [MenuItemController::class, 'destroyImage'])->name('delete-item-image');
        
        Route::get('gst-slabs', [GSTSlabController::class, 'index'])->name('gst-slabs');
        Route::post('gst-slabs', [GSTSlabController::class, 'store'])->name('gst-slabs.store');

        Route::get('menu-items', [MenuItemController::class, 'index'])->name('menu-items');
        Route::post('menu-items', [MenuItemController::class, 'store'])->name('menu-items.store');
        Route::get('menu-items/{menuItem}', [MenuItemController::class, 'show'])->name('menu-items.single');
        Route::get('iframe-pages/item-edit-form/{menuItem}', [MenuItemController::class, 'show'])->name('iframe-pages.item-edit-form');
        Route::put('menu-items/{menuItem}', [MenuItemController::class, 'update'])->name('menu-items.update');
        Route::delete('menu-items/{menuItem}', [MenuItemController::class, 'destroy'])->name('menu-items.destroy');
        Route::delete('menu-items/images/{image}', [MenuItemController::class, 'destroyImage'])->name('menu-items.destroy-image');

        Route::get('home-component', [HomeLayoutController::class, 'index'])->name('home-component');
        Route::get('home-component/create', [HomeLayoutController::class, 'create'])->name('home-component.create');
        Route::post('home-component', [HomeLayoutController::class, 'store'])->name('home-component.store');
        Route::get('home-component/{homeLayout}/edit', [HomeLayoutController::class, 'edit'])->name('home-component.edit');
        Route::put('home-component/{homeLayout}', [HomeLayoutController::class, 'update'])->name('home-component.update');
        Route::delete('home-component/{homeLayout}', [HomeLayoutController::class, 'destroy'])->name('home-component.destroy');

        Route::get('component-orders', [HomeComponentOrderController::class, 'index'])->name('component-orders');
        Route::put('component-order', [HomeComponentOrderController::class, 'updateOrder'])->name('component-order.update');
    });
});
