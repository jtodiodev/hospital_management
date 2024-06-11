<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;

class MedicalRecordController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_name' => 'required|string',
            'date' => 'required|date',
            'eent' => 'nullable|string',
            'heart' => 'nullable|string',
            'lungs' => 'nullable|string',
            'abdomen' => 'nullable|string',
            'genitalia' => 'nullable|string',
            'extremities' => 'nullable|string',
            'impression' => 'nullable|string',
            'treatment' => 'nullable|string'
        ]);

        $medicalRecord = MedicalRecord::create($validatedData);

        return response()->json($medicalRecord, 201);
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validatedData = $request->validate([
            'patient_name' => 'required|string',
            'date' => 'required|date',
            'eent' => 'nullable|string',
            'heart' => 'nullable|string',
            'lungs' => 'nullable|string',
            'abdomen' => 'nullable|string',
            'genitalia' => 'nullable|string',
            'extremities' => 'nullable|string',
            'impression' => 'nullable|string',
            'treatment' => 'nullable|string'
        ]);

        $medicalRecord->update($validatedData);

        return response()->json($medicalRecord, 200);
    }

    public function index()
    {
        $medicalRecords = MedicalRecord::all();
        return response()->json($medicalRecords);
    }
}
