<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function checkIn(Request $request): JsonResponse
    {
        $user = $request->user();
        $today = Carbon::today()->toDateString();

        $existing = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if ($existing && $existing->check_in) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have already checked in today.',
            ], 422);
        }

        $attendance = Attendance::updateOrCreate(
            ['user_id' => $user->id, 'date' => $today],
            ['check_in' => Carbon::now()->format('H:i:s')]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Check-in recorded',
            'data' => $attendance,
        ]);
    }

    public function checkOut(Request $request): JsonResponse
    {
        $user = $request->user();
        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if (! $attendance || ! $attendance->check_in) {
            return response()->json([
                'status' => 'error',
                'message' => 'You must check in before checking out.',
            ], 422);
        }

        if ($attendance->check_out) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have already checked out today.',
            ], 422);
        }

        $attendance->update([
            'check_out' => Carbon::now()->format('H:i:s'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Check-out recorded',
            'data' => $attendance,
        ]);
    }

    public function history(Request $request): JsonResponse
    {
        $records = Attendance::where('user_id', $request->user()->id)
            ->orderByDesc('date')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $records,
        ]);
    }
}
