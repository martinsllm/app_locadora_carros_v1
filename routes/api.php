<?php

use App\Http\Controllers\CarroController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LocacaoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->middleware('jwt.auth')->group(function () {
    Route::apiResource('/cliente', ClienteController::class)->middleware('can:admin');
    Route::apiResource('/carro', CarroController::class);
    Route::apiResource('/locacao', LocacaoController::class);
    Route::apiResource('/marca', MarcaController::class);
    Route::apiResource('/modelo', ModeloController::class);
    Route::post('/me', [App\Http\Controllers\AuthController::class, 'me']);
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
});

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/refresh', [App\Http\Controllers\AuthController::class, 'refresh']);

