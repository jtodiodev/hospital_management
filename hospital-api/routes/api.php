<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
<<<<<<< HEAD
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

// Appointment routes using resourceful routing
Route::resource('appointments', AppointmentController::class)->except([
>>>>>>> 2a526ae408b14082324fef24f913864239a237e9
    'create', 'edit'
]);
