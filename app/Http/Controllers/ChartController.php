<?php

namespace App\Http\Controllers;

use App\Models\WorkingTime;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function get_first_day()
    {
        $firstDay = WorkingTime::orderBy('date_checkin', "asc")
            ->value('date_checkin');
        $firstDay =  $firstDay ? Carbon::parse($firstDay)->format('Y-m-d') : null;
        return response()->json(['firstDay' => $firstDay]);
    }
    public function getData(Request $request)
    {
        // Gọi phương thức get_first_day để lấy ngày đầu tiên
        $firstDayResponse = $this->get_first_day();
        $firstDayData = json_decode($firstDayResponse->content(), true);
        $firstDay = $firstDayData['firstDay'];

        // Lấy ngày bắt đầu và ngày kết thúc từ yêu cầu
        $startDate = $request->input("startDate");
        $endDate = $request->input("endDate");

        // Nếu ngày bắt đầu không được cung cấp, sử dụng ngày đầu tiên
        $startDate = $startDate ?: $firstDay;

        // Nếu ngày kết thúc không được cung cấp, sử dụng ngày hiện tại
        $endDate = $endDate ?: Carbon::now()->format('Y-m-d');


        // Lấy dữ liệu check-in đúng giờ
        $checkInData = WorkingTime::whereBetween('date_checkin', [$startDate, $endDate])
            ->whereTime('time_checkin', '>', '08:00:00') // Kiểm tra check-in đúng giờ
            ->selectRaw('DATE(date_checkin) as date')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Lấy dữ liệu check-out đúng giờ
        $checkOutData = WorkingTime::whereBetween('date_checkin', [$startDate, $endDate])
            ->whereTime('time_checkout', '<', '17:30:00') // Kiểm tra check-out đúng giờ
            ->selectRaw('DATE(date_checkin) as date')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Lấy tất cả các ngày có dữ liệu check-in hoặc check-out
        $allDates = array_unique(array_merge(array_keys($checkInData), array_keys($checkOutData)));

        // Sắp xếp ngày
        sort($allDates);

        // Sắp xếp dữ liệu check-in và check-out theo ngày
        $checkInDataSorted = array_map(function ($date) use ($checkInData) {
            return $checkInData[$date] ?? 0;
        }, $allDates);

        $checkOutDataSorted = array_map(function ($date) use ($checkOutData) {
            return $checkOutData[$date] ?? 0;
        }, $allDates);

        return response()->json([
            'startDate' => $startDate,
            'endDate' => $endDate,
            'checkInData' => $checkInDataSorted,
            'checkOutData' => $checkOutDataSorted,
            'labels' => $allDates
        ]);
    }
}