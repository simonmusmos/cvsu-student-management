<?php

use App\Http\Controllers\api\SeatController;
use App\Http\Controllers\api\UserController;
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

Route::post('/auth/login', [UserController::class, 'userLogin']);
Route::get('/auth/logout', [UserController::class, 'userLogout']);
Route::get('/auth/details', [UserController::class, 'userDetail'])->middleware('auth_api:sanctum');

Route::get('/section/seats', [SeatController::class, 'getSeats'])->middleware('auth_api:sanctum');
Route::get('/section/seat', [SeatController::class, 'checkSeats'])->middleware('auth_api:sanctum');
Route::post('/section/seat', [SeatController::class, 'useSeat'])->middleware('auth_api:sanctum');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
