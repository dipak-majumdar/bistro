<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Admin API 
use App\Http\Controllers\Admin\API\ComponentController;

// Web API 
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\RazorpayWebhookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// routes/api.php is already mounted at /api by the RouteServiceProvider
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/home', [HomeController::class, 'index']);
Route::apiResource('items', ItemController::class);

// Cart JSON routes
Route::get('/cart/items', [CartController::class, 'index']);
Route::post('/cart/items', [CartController::class, 'store']);
Route::delete('/cart/items/{id}', [CartController::class, 'destroy']);

// Razorpay routes
Route::post('/razorpay/create-order', [RazorpayController::class, 'createOrder']);

// Order routes
Route::post('/orders/checkout', [OrderController::class, 'checkout']);
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);

// Razorpay webhook (should be excluded from CSRF protection)
Route::post('/razorpay/webhook', [RazorpayWebhookController::class, 'handle'])
    ->middleware('throttle:60,1');

// Admin API Routes 
Route::get('/admin/component/{componentId}', [ComponentController::class, 'getComponentById']);
Route::get('/admin/component/by-name/{componentName}', [ComponentController::class, 'getComponentByName']);
Route::put('/admin/component/{componentId}', [ComponentController::class, 'updateComponent']);
Route::delete('/admin/component/{componentId}', [ComponentController::class, 'destroy']);

