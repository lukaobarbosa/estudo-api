<?php

use App\Http\Controllers\PokemonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResourceController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user', [PokemonController::class, 'index'])->name('index');
Route::get('/user/{user}', [PokemonController::class, 'show'])->name('show');
Route::delete('/user/{user}', [PokemonController::class,'delete'])->name('delete');
Route::post('/user', [PokemonController::class, 'create'])->name('create');
Route::put('/user/{user}', [PokemonController::class, 'update'])->name('update');

