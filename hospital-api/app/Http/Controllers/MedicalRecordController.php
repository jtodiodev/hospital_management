<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $patients = MedicalRecord::all();
        return response()->json($patients);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'age' => 'required|integer',
            'diagnosis' => 'required',
            'date' => 'required|date',
        ]);

        $patient = MedicalRecord::create($validatedData);

        return response()->json($patient, 201);
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'age' => 'required|integer',
            'diagnosis' => 'required',
            'date' => 'required|date',
        ]);

        $medicalRecord->update($validatedData);

        return response()->json($medicalRecord, 200);
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();

        return response()->json(null, 204);
    }
}
