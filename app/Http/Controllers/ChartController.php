<?php

namespace App\Http\Controllers;

use App\Models\WorkingTime;
use App\Models\User;

use Carbon\Carbon;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function getData(Request $request)
    {
        $startDate = $request->input("startDate");
        $endDate = $request->input("endDate");

        $startDate = $startDate ?: Carbon::now()->format('d');
        $endDate = $endDate ?: Carbon::now()->format('d');

        $checkInData = WorkingTime::whereBetween('date_checkin', [$startDate, $endDate])
            ->whereTime('time_checkin', '<', '08:00:00')
            ->selectRaw('DATE(date_checkin) as date')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $checkOutData = WorkingTime::whereBetween('date_checkin', [$startDate, $endDate])
            ->whereTime('time_checkout', '>', '17:30:00')
            ->selectRaw('DATE(date_checkin) as date')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        return response()->json([
            'checkInData' => $checkInData,
            'checkOutData' => $checkOutData,
            'labels' => $checkInData->keys()
        ]);
    }
}
