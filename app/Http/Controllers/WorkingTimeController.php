<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkingTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class WorkingTimeController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $today = Carbon::today()->toDateString();
        $workingTime = WorkingTime::where('user_id', $user_id)->where('date_checkin', $today)->first();
        return response()->json($workingTime);
    }
    public function checkStatus()
    {
        $user_id = Auth::id();
        $today = Carbon::today()->toDateString();
        $workingTime = WorkingTime::where('user_id', $user_id)->where('date_checkin', $today)->first();

        if (!$workingTime) {
            return response()->json(['status' => 'not_working', 'message' => 'No working record found for today.']);
        }
        if ($workingTime->time_checkin && !$workingTime->time_checkout) {
            return response()->json(['status' => 'checked_in', 'message' => 'You are currently checked in.']);
        }
        if ($workingTime->time_checkout) {
            return response()->json(['status' => 'checked_out', 'message' => 'You have already checked out.']);
        }

        return response()->json(['status' => 'not_working', 'message' => 'No working record found for today.']);
    }


    public function checkIn(Request $request)
    {
        $user_id = Auth::id();
        $today = Carbon::today()->toDateString();

        $workingTime = WorkingTime::where('user_id', $user_id)->where('date_checkin', $today)->first();
        if (!$workingTime) {
            return response()->json(['status' => 'failed', 'message' => 'No working record found for today.']);
        }
        if ($workingTime->time_checkin) {
            return response()->json(['status' => 'failed', 'message' => 'Already checked in.']);
        }
        $workingTime->update([
            'time_checkin' => Carbon::now('Asia/Ho_Chi_Minh')
        ]);
        return response()->json(['status' => 'success', 'message' => 'Check-in successful.']);
    }

    public function checkOut(Request $request)
    {
        $user_id = Auth::id();
        $today = Carbon::today()->toDateString();

        $workingTime = WorkingTime::where('user_id', $user_id)->where('date_checkin', $today)->first();
        if (!$workingTime || $workingTime->time_checkout) {
            return response()->json(['status' => 'failed', 'message' => 'Check-out failed.']);
        }
        $workingTime->update([
            'time_checkout' => Carbon::now('Asia/Ho_Chi_Minh')
        ]);
        return response()->json(['status' => 'success', 'message' => 'Check-out successful.']);
    }


    public function getMonthReport(Request $request)
    {
        $user_id = Auth::id();
        $month = $request->input('month');
        $year = $request->input('year');

        $month = $month ?: Carbon::now()->format('m');
        $year = $year ?: Carbon::now()->format('Y');

        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth()->toDateString();
        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth()->toDateString();

        $workingTimes = WorkingTime::where('user_id', $user_id)
            ->whereBetween('date_checkin', [$startOfMonth, $endOfMonth])
            ->get();

        $report = $workingTimes->map(function ($workingTime) {
            $status = [];
            $checkInTime = $workingTime->time_checkin ? Carbon::parse($workingTime->time_checkin) : null;
            $checkOutTime = $workingTime->time_checkout ? Carbon::parse($workingTime->time_checkout) : null;

            $workStartTime = Carbon::parse($workingTime->date_checkin . '09:00:00');
            $workEndTime = Carbon::parse($workingTime->date_checkin . '17:30:00');

            $today = Carbon::today();
            $previousDay = $today->copy()->subDay()->toDateString();

            if ($checkInTime === null && $workingTime->date_checkin <= $previousDay) {
                $status = 'Absent';
            } else {
                if ($checkInTime && $checkInTime->gt($workStartTime)) {
                    $status[] = 'Late';
                }
                if ($checkInTime && $checkOutTime->lt($workEndTime)) {
                    $status[] = 'Early';
                }
            }
            return [
                'date' => $workingTime->date_checkin,
                'status' => $status,
                'time_checkin' => $workingTime->time_checkin,
                'time_checkout' => $workingTime->time_checkout,
            ];
        });

        return response()->json($report);
    }
}
