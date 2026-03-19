<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\HeroController;
use App\Http\Controllers\Api\DraftPlanController;
use App\Http\Controllers\Api\DraftPlanBanController;
use App\Http\Controllers\Api\DraftPlanPreferredPickController;
use App\Http\Controllers\Api\DraftPlanEnemyThreatController;
use App\Http\Controllers\Api\DraftPlanItemTimingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Hero Routes
Route::get('/heroes', [HeroController::class, 'index']);
Route::get('/heroes/{hero}', [HeroController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Draft Plan Routes
    Route::get('/draft-plans', [DraftPlanController::class, 'index']);
    Route::post('/draft-plans', [DraftPlanController::class, 'store']);
    Route::get('/draft-plans/{id}', [DraftPlanController::class, 'show']);
    Route::put('/draft-plans/{id}', [DraftPlanController::class, 'update']);
    Route::delete('/draft-plans/{id}', [DraftPlanController::class, 'destroy']);
    Route::get('/draft-plans/{id}/summary', [DraftPlanController::class, 'summary']);

    // Bans
    Route::get('/draft-plans/{id}/bans', [DraftPlanBanController::class, 'index']);
    Route::post('/draft-plans/{id}/bans', [DraftPlanBanController::class, 'store']);
    Route::put('/draft-plans/{id}/bans/{banId}', [DraftPlanBanController::class, 'update']);
    Route::delete('/draft-plans/{id}/bans/{banId}', [DraftPlanBanController::class, 'destroy']);

    // Preferred Picks
    Route::get('/draft-plans/{id}/preferred-picks', [DraftPlanPreferredPickController::class, 'index']);
    Route::post('/draft-plans/{id}/preferred-picks', [DraftPlanPreferredPickController::class, 'store']);
    Route::put('/draft-plans/{id}/preferred-picks/{pickId}', [DraftPlanPreferredPickController::class, 'update']);
    Route::delete('/draft-plans/{id}/preferred-picks/{pickId}', [DraftPlanPreferredPickController::class, 'destroy']);

    // Enemy Threats
    Route::get('/draft-plans/{id}/enemy-threats', [DraftPlanEnemyThreatController::class, 'index']);
    Route::post('/draft-plans/{id}/enemy-threats', [DraftPlanEnemyThreatController::class, 'store']);
    Route::put('/draft-plans/{id}/enemy-threats/{threatId}', [DraftPlanEnemyThreatController::class, 'update']);
    Route::delete('/draft-plans/{id}/enemy-threats/{threatId}', [DraftPlanEnemyThreatController::class, 'destroy']);

    // Item Timings
    Route::get('/draft-plans/{id}/item-timings', [DraftPlanItemTimingController::class, 'index']);
    Route::post('/draft-plans/{id}/item-timings', [DraftPlanItemTimingController::class, 'store']);
    Route::put('/draft-plans/{id}/item-timings/{timingId}', [DraftPlanItemTimingController::class, 'update']);
    Route::delete('/draft-plans/{id}/item-timings/{timingId}', [DraftPlanItemTimingController::class, 'destroy']);
});
