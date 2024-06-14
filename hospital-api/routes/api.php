<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ScheduleController;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/users', [AuthController::class, 'getAllUsers']);
Route::get('/user/{id}', [AuthController::class, 'getUser']);
Route::get('/alldoctors', [AuthController::class, 'getAllDoctors']);
Route::get('/doctor/{id}', [AuthController::class, 'getDoctor']);
Route::put('/user/{id}', [AuthController::class, 'updateUser']);
Route::delete('/user/{id}', [AuthController::class, 'deleteUser']);

Route::middleware('auth:sanctum',)-> get('/user', function (Request $request) {
    return response()->json([
        'role' => $request->user()->role,
        'name' => $request->user()->name,
        'email' => $request->user()->email,
    ]);
});

Route::get('/patients', [PatientsController::class, 'index']);
Route::post('/patients', [PatientsController::class, 'store']);
Route::get('/patients/{caseNo}', [PatientsController::class, 'show']);
Route::put('/patients/{caseNo}', [PatientsController::class, 'update']);
Route::delete('/patients/{caseNo}', [PatientsController::class, 'destroy']);

Route::get('/doctors', [DoctorController::class, 'findAll']);
Route::post('/doctors', [DoctorController::class, 'store']);
Route::get('/doctors/{id}', [DoctorController::class, 'findDoctor']);
Route::put('/doctors/{id}', [DoctorController::class, 'edit']);
Route::delete('/doctors/{id}', [DoctorController::class, 'delete']);

Route::get('/schedules', [ScheduleController::class, 'index']);
Route::post('/schedules', [ScheduleController::class, 'store']);
Route::get('/schedules/{id}', [ScheduleController::class, 'show']);
Route::put('/schedules/{id}', [ScheduleController::class, 'update']);
Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy']);