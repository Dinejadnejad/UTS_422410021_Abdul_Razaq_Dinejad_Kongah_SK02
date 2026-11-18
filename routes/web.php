<?php

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ObservationSessionController;
use App\Http\Controllers\TargetObjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('observation-sessions.index'));

Route::resource('observation-sessions', ObservationSessionController::class);
Route::resource('target-objects', TargetObjectController::class)->except(['show']);
Route::resource('equipments', EquipmentController::class)->except(['show']);