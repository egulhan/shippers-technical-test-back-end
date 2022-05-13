<?php

use App\Http\Controllers\Api\ContactsController;
use App\Http\Controllers\Api\ShippersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('shippers')->group(function () {
    Route::get('', [ShippersController::class, 'index'])->name('shippers.index');
    Route::post('', [ShippersController::class, 'store'])->name('shippers.store');
    Route::patch('/{shipper}', [ShippersController::class, 'update'])->name('shippers.update');
    Route::get('/{shipper}/contacts', [ShippersController::class, 'listContacts'])
        ->name('shippers.list_contacts');
    Route::post('/{shipper}/contacts', [ContactsController::class, 'store'])->name('contacts.store');
    Route::patch('/{shipper}/contacts/{contact}/pick-as-primary', [ContactsController::class, 'pickAsPrimary'])
        ->name('contacts.pick_as_primary');
    Route::delete('/{shipper}/contacts/{contact}', [ContactsController::class, 'destroy'])
        ->name('contacts.destroy');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
