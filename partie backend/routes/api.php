<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\CommandeController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProduitController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::as('api.')->group(function () {
    // Auth
    Route::controller(AuthController::class)->group(function () {
        Route::post('/register', 'register')->name('register');
        Route::post('/login', 'login')->name('login');
        Route::middleware('auth:sanctum')->delete('/logout', 'logout')->name('logout');
    });

    // Route::get('/clients', [ClientController::class, 'index']);
    // Route::post('/clients', [ClientController::class, 'store']);
    // Route::get('/clients/{id}', [ClientController::class, 'show']);
    // Route::put('/clients/{id}', [ClientController::class, 'update']);
    // Route::delete('/clients/{id}', [ClientController::class, 'destroy']);
    // OR 
    Route::apiresource('clients', ClientController::class);

    // Route::get('/produits', [ProduitController::class, 'index']);
    // Route::post('/produits', [ProduitController::class, 'store']);
    // Route::get('/produits/{produit}', [ProduitController::class, 'show']);
    // Route::put('/produits/{produit}', [ProduitController::class, 'update']);
    // Route::delete('/produits/{produit}', [ProduitController::class, 'destroy']);
    // Route::resource('products', ProduitController::class);
    //OR
    Route::apiresource('products', ProduitController::class);


    Route::get('/commandes',[CommandeController::class,'gettall']);
    Route::post('/commandes/{client_id}/{produit_id}', [CommandeController::class, 'commander']);
    Route::get('/commandes/{id}', [CommandeController::class, 'afficherCommande']);
    Route::get('/commandesJoin/{id}', [CommandeController::class, 'afficherCommandeJoin']);


});

