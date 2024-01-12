<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserReminderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("ping", function(){
    return response()->json(["data" => "pong"]);
});

Route::post("register", [AuthController::class, 'registration']);
Route::post("session", [AuthController::class, 'login']);
Route::put("session", [AuthController::class, 'refreshToken'])->middleware(['auth:sanctum', 'refresh.token']);

Route::prefix('reminders')->middleware(['auth:sanctum', 'access.token'])->group(function () {
    Route::post('/', [UserReminderController::class, 'store']);
    Route::get('/', [UserReminderController::class, 'getListReminder']);
    Route::get('/{userReminder}', [UserReminderController::class, 'show']);
    Route::put('/{userReminder}', [UserReminderController::class, 'update']);
    Route::delete('/{userReminder}', [UserReminderController::class, 'destroy']);
});