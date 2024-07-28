<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/send-email', [EmailController::class, 'sendEmailToQueue']);
Route::post('/test-send', [EmailController::class, 'sendEmailToQueuePerformance']);
Route::get('/emails', [EmailController::class, 'getEmails']);
