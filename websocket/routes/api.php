<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('messages/{id}',[\App\Http\Controllers\MessageController::class, 'messageList'])->name('message.list');
Route::post('messages/{id}',[\App\Http\Controllers\MessageController::class, 'messageStore'])->name('message.store');
