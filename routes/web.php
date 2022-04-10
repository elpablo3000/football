<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/route-name/?{name}', function(){
    return redirect('/');
})->where('name', '[A-Za-z]+');


Route::get('api/teams', [App\Http\Controllers\TeamsController::class, 'index'])->name('api/teams');
Route::get('api/fixtures', [App\Http\Controllers\FixturesController::class, 'index'])->name('api/fixtures');
Route::get('api/tournament/{weekNumber}', [App\Http\Controllers\TournamentController::class, 'index'])->name('api/tournament');
Route::post('api/reset', [App\Http\Controllers\ResetController::class, 'index'])->name('api/tournament');

//Route::get('fixtures', [App\Http\Controllers\FixturesController::class, 'index'])->name('fixtures');
//Route::get('tournament/{weekNumber}', [App\Http\Controllers\TournamentController::class, 'index'])->name('tournament');
