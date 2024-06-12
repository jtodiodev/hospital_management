<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum',)-> get('/user', function (Request $request) {
    return response()->json([
        'role' => $request->user()->role,
        'name' => $request->user()->name,
        'email' => $request->user()->email,
    ]);
});

// Doctor routes using resourceful routing
Route::resource('doctors', DoctorController::class)->except([
    'create', 'edit'
]);
Route::resource('medical-record', MedicalRecordController::class)->except([
    'create', 'edit'
]);
