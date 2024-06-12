<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return response()->json($doctors);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|unique:doctors,email',
        ]);

        $doctor = Doctor::create($validatedData);
        return response()->json($doctor, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $doctor = Doctor::findOrFail($id);
        return response()->json($doctor);
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => ['required', 'email', Rule::unique('doctors')->ignore($doctor->id)],
        ]);

        $doctor->update($validatedData);
        return response()->json($doctor, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Doctor::destroy($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
