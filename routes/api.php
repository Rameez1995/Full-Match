<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ClubController;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\SubsPlanController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/allcustomers', [CustomerController::class , 'index']);

Route::get('/clubs', [ClubController::class , 'clubs']);
Route::get('/club/{id}', [ClubController::class , 'club']);

Route::get('/players', [PlayerController::class , 'players']);
Route::get('/player/{id}', [PlayerController::class , 'player']);

Route::get('/customer/{id}', [CustomerController::class , 'show']);

Route::get('/allsubsplans', [SubsPlanController::class , 'index']);

Route::get('/videos', [VideoController::class , 'videos']);
Route::get('/video/{id}', [VideoController::class , 'video_details']);
