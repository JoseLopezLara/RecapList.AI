<?php

use App\Http\Controllers\RecapsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/recaps-store', [RecapsController::class, 'store']);
