<?php

use App\Http\Controllers\Api\ExamApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ExamApiController::class, 'login']);
Route::get('/config', [ExamApiController::class, 'getConfig']);
Route::post('/heartbeat', [ExamApiController::class, 'heartbeat']);
Route::post('/session-status/{id}/{status}', [ExamApiController::class, 'sessionStatus']);
Route::post('/clear-message', [ExamApiController::class, 'clearMessage']);
Route::post('/clear-command', [ExamApiController::class, 'clearCommand']);
Route::post('/log', [ExamApiController::class, 'reportCheat']);
