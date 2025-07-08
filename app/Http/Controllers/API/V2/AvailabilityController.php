<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkerAvailability;
use App\Models\User;


class AvailabilityController extends Controller
{
    //
    
public function store(Request $request)
{
    $request->validate([
        'availabilities' => 'required|array',
        'availabilities.*.day' => 'required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
        'availabilities.*.start_time' => 'required|date_format:H:i',
        'availabilities.*.end_time' => 'required|date_format:H:i|after:availabilities.*.start_time',
    ]);

    $worker = auth('user')->user();

    if ($worker->role !== 'worker') {
        return response()->json(['message' => 'Only workers can define availability.'], 403);
    }

    $grouped = collect($request->availabilities)->groupBy('day');

    foreach ($grouped as $day => $slots) {
        $worker->availabilities()->where('day', $day)->delete();

        foreach ($slots as $slot) {
            WorkerAvailability::create([
                'worker_id' => $worker->id,
                'day' => $day,
                'start_time' => $slot['start_time'],
                'end_time' => $slot['end_time'],
            ]);
        }
    }

    return response()->json(['message' => 'Availability updated successfully.']);
}


public function getWorkerAvailability($workerId)
{
    $worker = User::with('availabilities')->findOrFail($workerId);

    $daysOfWeek = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

    $availability = [];
    foreach ($daysOfWeek as $day) {
    $slots = $worker->availabilities
        ->where('day', $day)
        ->map(function ($slot) {
            return [
                'start_time' => $slot->start_time,
                'end_time' => $slot->end_time,
            ];
        })->values();

    $availability[] = [
        'day' => $day,
        'slots' => $slots,
    ];
}

    return response()->json([
        'worker_id' => $worker->id,
        'availability' => $availability,
    ]);
}


}
