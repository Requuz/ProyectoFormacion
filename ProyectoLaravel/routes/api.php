<?php

use App\Models\Starship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PilotsController;
use App\Http\Controllers\Api\StarshipPilotController;




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

Route::get('/starships', function () {
    return Starship::with('pilots')->get();
});

Route::apiResource('starship_pilot', StarshipPilotController::class)->only(['index']);
Route::delete('starship_pilot/{id}', [StarshipPilotController::class, 'destroy']);
Route::post('starship_pilot/link_pilot', [StarshipPilotController::class, 'linkPilot']);
