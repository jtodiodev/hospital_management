<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patients;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;


class PatientsController extends Controller
{
    public function index()
    {
        $patients = Patients::all();
        return response()->json($patients);
    }

    public function store(Request $request)
    {
        $caseNo = substr(str_shuffle(MD5(microtime())), 0, 12);
        while ($this->checkCaseNoExists($caseNo)) {
            $caseNo = substr(str_shuffle(MD5(microtime())), 0, 6);
        }
        $patient = new Patients();
        $patient->caseNo = $caseNo;
        $patient->patient_ID = $request->input('patient_ID');
        $patient->name = $request->input('name');
        $patient->gender = $request->input('gender');
        $patient->age = $request->input('age');
        $patient->contactNo = $request->input('contactNo');
        $patient->save();
        return response()->json($patient);
    }
    
    private function checkCaseNoExists($caseNo)
    {
        return Patients::where('caseNo', $caseNo)->exists();
    }

    public function show($caseNo)
    {
        $patient = Patients::where('caseNo', (string) $caseNo)->first();
        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }
        return response()->json($patient);
    }

    public function update(Request $request, $caseNo)
    {
        $patient = Patients::where('caseNo', $caseNo)->first();
        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }
        $patient->patient_ID = $request->input('patient_ID');
        $patient->name = $request->input('name');
        $patient->gender = $request->input('gender');
        $patient->age = $request->input('age');
        $patient->contactNo = $request->input('contactNo');
        $patient->save();
        return response()->json($patient);
    }

public function destroy($caseNo)
{
    $patient = Patients::where('caseNo', $caseNo)->first();
    if (!$patient) {
        return response()->json(['error' => 'Patient not found'], 404);
    }
    $patient->delete();
    return response()->json(['message' => 'Patient deleted successfully']);
}
}