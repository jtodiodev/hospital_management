<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/medical-records', [MedicalRecordController::class, 'store']);
    Route::put('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'update']);
    Route::get('/medical-records', [MedicalRecordController::class, 'index']); // Add this line
    // Define other routes as needed
});


