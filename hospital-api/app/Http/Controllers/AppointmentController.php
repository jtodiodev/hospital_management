<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('doctor')->get();
        return response()->json($appointments);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_name' => 'required|string|max:255',
            'doctor_name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        // Find doctor by name
        $doctor = Doctor::where('name', $validatedData['doctor_name'])->first();

        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found'], Response::HTTP_NOT_FOUND);
        }

        $appointment = new Appointment();
        $appointment->patient_name = $validatedData['patient_name'];
        $appointment->doctor_name = $doctor->name;
        $appointment->date = $validatedData['date'];
        $appointment->time = $validatedData['time'];
        $appointment->save();

        return response()->json($appointment, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $appointment = Appointment::with('doctor')->findOrFail($id);
        return response()->json($appointment);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $validatedData = $request->validate([
            'patient_name' => 'required|string|max:255',
            'doctor_name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        $doctor = Doctor::where('name', $validatedData['doctor_name'])->first();

        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found'], Response::HTTP_NOT_FOUND);
        }

        $appointment->patient_name = $validatedData['patient_name'];
        $appointment->doctor_name = $doctor->name;
        $appointment->date = $validatedData['date'];
        $appointment->time = $validatedData['time'];
        $appointment->save();

        return response()->json($appointment, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Appointment::destroy($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
