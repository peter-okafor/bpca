<?php

use App\Http\Controllers\LocalitiesController;
use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\PestController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/omnet/callback', [OrganisationController::class, 'create']);
Route::get('/search/postcode/{postcode}/pestcode/{pestcode}', [OrganisationController::class, 'find']);
Route::get('/pests', [PestController::class, 'index']);
Route::get('/pest/filter', [PestController::class, 'filter']);
Route::get('/localities', [LocalitiesController::class, 'get']);
