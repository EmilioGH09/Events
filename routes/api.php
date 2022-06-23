<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtistsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\PurchasesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/live', function(){
    return response(['live'], 200);
});

Route::group([ 'prefix' => 'artists'], function () {
    Route::get("/", [ArtistsController::class, 'index'])->name('artist.index');
    Route::post('/', [ArtistsController::class, 'create'])->name('artist.create');
    Route::group( ['prefix' => '{artist}'], function () {
        Route::get("/", [ArtistsController::class, 'show'])->name('artist.show');
        Route::patch('/', [ArtistsController::class, 'update'])->name('artist.update');
        Route::delete('/', [ArtistsController::class, 'destroy'])->name('artist.destroy');
    });
});

Route::group([ 'prefix' => 'purchases'], function () {
    Route::get("/", [PurchasesController::class, 'index'])->name('purchase.index');
    Route::post('/', [PurchasesController::class, 'create'])->name('purchase.create');
    Route::group( ['prefix' => '{purchase}'], function () {
        Route::get("/", [PurchasesController::class, 'show'])->name('purchase.show');
        Route::patch('/', [PurchasesController::class, 'update'])->name('purchase.update');
        Route::delete('/', [PurchasesController::class, 'destroy'])->name('purchase.destroy');
    });
});

Route::group([ 'prefix' => 'tickets'], function () {
    Route::get("/", [TicketsController::class, 'index'])->name('ticket.index');
    Route::group( ['prefix' => '{ticket}'], function () {
        Route::get("/", [TicketsController::class, 'show'])->name('ticket.show');
        Route::patch('/', [TicketsController::class, 'update'])->name('ticket.update');
        Route::delete('/', [TicketsController::class, 'destroy'])->name('ticket.destroy');
    });
});

Route::group([], function () {
    Route::get("/", [EventsController::class, 'index'])->name('event.index');
    Route::post('/{artist}', [EventsController::class, 'create'])->name('event.create');
    Route::group( ['prefix' => '{event}'], function () {
        Route::post('/tickets', [TicketsController::class, 'create'])->name('ticket.create');
        Route::get("/", [EventsController::class, 'show'])->name('event.show');
        Route::patch('/', [EventsController::class, 'update'])->name('event.update');
        Route::delete('/', [EventsController::class, 'destroy'])->name('event.destroy');
    });
});

