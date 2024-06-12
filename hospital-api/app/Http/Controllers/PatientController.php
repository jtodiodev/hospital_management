<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class PatientController extends Controller
{
    // Display a listing of the patients.
    public function index()
    {
        $patients = Patient::all();
        return response()->json($patients);
    }

    // Store a newly created patient in storage.
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $patient = Patient::create($validatedData);
        return response()->json($patient, Response::HTTP_CREATED);
    }

    // Display the specified patient.
    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return response()->json($patient);
    }

    // Update the specified patient in storage.
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $patient->update($validatedData);
        return response()->json($patient, Response::HTTP_OK);
    }

    // Remove the specified patient from storage.
    public function destroy($id)
    {
        Patient::destroy($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
