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
Route::get('/', function () {
    return [
        'version' => '1.0.0'
    ];
});

Route::get('/lost_pets/search', [\App\Http\Controllers\Api\LostPetController::class, 'search']);
Route::apiResource('/lost_pets', \App\Http\Controllers\Api\LostPetController::class);
Route::apiResource('/pet_details', \App\Http\Controllers\Api\PetDetailController::class);
