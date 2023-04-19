<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StarshipController;
use App\Http\Controllers\PilotsController;
use App\Http\Controllers\StarshipPilotController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/starships', function () {
    return view('starships');
});

Route::get('/starships', [StarshipController::class, 'index']);

Route::get('/pilots', function () {
    return view('pilots');
});

Route::get('/pilots', [PilotsController::class, 'index']);

Route::get('/starshipPilot', function () {
    return view('starshipPilot');
});

Route::get('/starshipPilot', [StarshipPilotController::class, 'index'])->name('starshipPilot');

Route::delete('/pilots/destroyByName', [StarshipPilotController::class, 'destroyByName'])->name('pilots.destroyByName');

Route::post('/starships/linkPilot', [StarshipPilotController::class, 'linkPilot'])->name('starships.linkPilot');


