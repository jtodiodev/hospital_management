<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all();
        return response()->json($schedules);
    }

    public function store(Request $request)
    {
        $schedule = new Schedule();
        $schedule->user_id = $request->input('user_id');
        $schedule->name = $request->input('name');
        $schedule->age = $request->input('age');
        $schedule->gender = $request->input('gender');
        $schedule->address = $request->input('address');
        $schedule->contactNo = $request->input('contactNo');
        $schedule->schedule = $request->input('schedule');
        $schedule->doctor_id = $request->input('doctor_id');
        $schedule->doctor_name = $request->input('doctor_name');
        $schedule->save();
        return response()->json($schedule);
    }

    public function show($id)
    {
        $schedule = Schedule::find($id);
        if (!$schedule) {
            return response()->json(['error' => 'Schedule not found'], 404);
        }
        return response()->json($schedule);
    }

    public function update(Request $request, $id)
    {
        $schedule = Schedule::find($id);
        if (!$schedule) {
            return response()->json(['error' => 'Schedule not found'], 404);
        }
        $schedule->user_id = $request->input('user_id');
        $schedule->name = $request->input('name');
        $schedule->age = $request->input('age');
        $schedule->gender = $request->input('gender');
        $schedule->address = $request->input('address');
        $schedule->contactNo = $request->input('contactNo');
        $schedule->schedule = $request->input('schedule');
        $schedule->doctor_id = $request->input('doctor_id');
        $schedule->doctor_name = $request->input('doctor_name');
        $schedule->save();
        return response()->json($schedule);
    }

    public function destroy($id)
    {
        $schedule = Schedule::find($id);
        if (!$schedule) {
            return response()->json(['error' => 'Schedule not found'], 404);
        }
        $schedule->delete();
        return response()->json(['message' => 'Schedule deleted successfully']);
    }
}