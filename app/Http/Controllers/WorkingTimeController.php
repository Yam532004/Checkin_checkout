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


    public function checkIn()
    {
        $user_id = Auth::id();
        $today = Carbon::today()->toDateString();
        $user = Auth::user();
        $user_role = $user->role; // Lấy vai trò của người dùng

        if ($user_role == 'admin') {
            return response()->json(['status' => 'failed', 'message' => 'You are Admin. That why you not allowed to check in.']);
        } else {
            $workingTime = WorkingTime::where('user_id', $user_id)->where('date_checkin', $today)->first();

            if (!$workingTime) {
                return response()->json(['status' => 'failed', 'message' => 'No working record found for today.']);
            } elseif ($workingTime->time_checkin) {
                return response()->json(['status' => 'failed', 'message' => 'Already checked in.']);
            }

            $workingTime->update([
                'time_checkin' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);

            $day = $workingTime->time_checkin->format('d/m/Y'); // Sửa định dạng ngày
            $time = $workingTime->time_checkin->format('H:i:s');
            $status = $time > '08:00:00' ? 'Late' : 'Early';

            return response()->json([
                'status' => 'success',
                'message' => 'Check-in successful.',
                'time' => $time,
                'day' => $day,
                'status_check_in' => $status
            ]);
        }
    }




    public function checkOut()
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

        $day = $workingTime->time_checkout->format('d/m/Y'); // Sửa định dạng ngày
        $time = $workingTime->time_checkout->format('H:i:s');
        $status = $time < '17:30:00' ? 'Early' : 'Late';
        return response()->json([
            'status' => 'success',
            'message' => 'Check-out successful.',
            'time' => $time,
            'day' => $day,
            'status_check_out' => $status
        ]);
    }


    public function getMonthReport(Request $request)
    {
        $user_id = $request->id;

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
            $user_id = Auth::id();
            $status = [];
            $checkInTime = $workingTime->time_checkin ? Carbon::parse($workingTime->time_checkin) : null;
            $checkOutTime = $workingTime->time_checkout ? Carbon::parse($workingTime->time_checkout) : null;

            $workStartTime = Carbon::parse($workingTime->date_checkin . '08:00:00');
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

    public function on_time(Request $request)
    {
        $day = $request->input('day');
        $month = $request->input('month');
        $year = $request->input('year');

        $day = $day ?: Carbon::now()->format('d');
        $month = $month ?: Carbon::now()->format('m');
        $year = $year ?: Carbon::now()->format('Y');


        $today = Carbon::create($year, $month, $day)->format('Y-m-d');

        // Đếm số lượng bản ghi thay vì lấy toàn bộ các bản ghi
        $onTimeCount = WorkingTime::whereDate('date_checkin', $today)
            ->whereNotNull('time_checkin')  
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->count();
        return response()->json(['count' => $onTimeCount]);
    }
    public function not_yet_checkin(Request $request){
        $day = $request->input('day');
        $month = $request->input('month');
        $year = $request->input('year');

        $day = $day ?: Carbon::now()->format('d');
        $month = $month ?: Carbon::now()->format('m');
        $year = $year ?: Carbon::now()->format('Y');

        $today = Carbon::create($year, $month, $day)->format('Y-m-d');
        
        $not_yet = WorkingTime::whereDate('date_checkin', $today)
            ->whereNull('time_checkin')
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at')
                    ->where('role', '!=', 'admin');
            })
            ->count();
        return response()->json(['count' => $not_yet]);
    }

    public function not_yet_checkout(Request $request)
    {
        $day = $request->input('day');
        $month = $request->input('month');
        $year = $request->input('year');

        $day = $day ?: Carbon::now()->format('d');
        $month = $month ?: Carbon::now()->format('m');
        $year = $year ?: Carbon::now()->format('Y');


        $today = Carbon::create($year, $month, $day)->format('Y-m-d');

        // Đếm số lượng bản ghi thay vì lấy toàn bộ các bản ghi
        $not_yet = WorkingTime::whereDate('date_checkin', $today)
            ->whereNotNull('time_checkin')
            ->whereNull('time_checkout')
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at')
                    ->where('role', '!=', 'admin');
            })
            ->count();

        return response()->json(['count' => $not_yet]);
    }

    public function get_late(Request $request)
    {
        $day = $request->input('day');
        $month = $request->input('month');
        $year = $request->input('year');

        $day = $day ?: Carbon::now()->format('d');
        $month = $month ?: Carbon::now()->format('m');
        $year = $year ?: Carbon::now()->format('Y');


        $today = Carbon::create($year, $month, $day)->format('Y-m-d');


        $late_users = WorkingTime::whereDate('date_checkin', $today)
            ->whereNotNull('time_checkin')
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->whereTime('time_checkin', '>', Carbon::parse('08:00:00'))
            ->count();

        return response()->json(['count' => $late_users]);
    }

    public function list_checkin_late(Request $request)
    {
        // Lấy ngày, tháng, năm từ request hoặc gán giá trị hiện tại nếu không có
        $day = $request->input('day');
        $month = $request->input('month');
        $year = $request->input('year');
        $day = $day ?: Carbon::now()->format('d');
        $month = $month ?: Carbon::now()->format('m');
        $year = $year ?: Carbon::now()->format('Y');

        $today = Carbon::create($year, $month, $day)->format('Y-m-d');


        $late_users = WorkingTime::whereDate('date_checkin', $today)
            ->whereNotNull('time_checkin') // Chỉ lấy những bản ghi có thời gian check-in
            ->whereTime('time_checkin', '>', '08:00:00') // Lọc các thời gian check-in sau 08:00:00
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at'); // Đảm bảo người dùng chưa bị xóa
            })
            ->with('user') // Eager load mối quan hệ 'user'
            ->get();

        // Xử lý dữ liệu để lấy danh sách người dùng check-in muộn
        $report = $late_users->map(function ($workingTime) {
            // Kiểm tra sự tồn tại của 'time_checkin' và chuyển đổi nó thành đối tượng Carbon
            if ($workingTime->time_checkin) {
                $checkInTime = Carbon::parse($workingTime->time_checkin);
                // Tạo thời gian chuẩn 09:00:00 cùng ngày check-in
                $standardTime = Carbon::create($checkInTime->format('Y-m-d') . ' 08:00:00');
                // Tính số phút đi muộn
                $minutesLate = $checkInTime->diffInMinutes($standardTime);

                return [
                    'name' => $workingTime->user->name ?? 'N/A',
                    'date' => $checkInTime->format('d-m-Y'), // Ngày check-in
                    'time_checkin' => $checkInTime->format('H:i:s'), // Thời gian check-in
                    'minutes_late' => $minutesLate, // Số phút đi muộn
                ];
            }
        });

        return response()->json(['list_checkin_late' => $report]);
    }
    public function checkout_early(Request $request)
    {
        $day = $request->input('day');
        $month = $request->input('month');
        $year = $request->input('year');

        $day = $day ?: Carbon::now()->format('d');
        $month = $month ?: Carbon::now()->format('m');
        $year = $year ?: Carbon::now()->format('Y');


        $today = Carbon::create($year, $month, $day)->format('Y-m-d');

        $not_yet_checkout_users = WorkingTime::whereDate('date_checkin', $today)
            ->whereNotNull('time_checkin')
            ->whereNotNull('time_checkout')
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->whereTime('time_checkout', '<', Carbon::parse('17:30:00'))
            ->count();

        return response()->json(['count' => $not_yet_checkout_users]);
    }

    public function list_checkin_late_in_month(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $month = $month ?: Carbon::now()->format('m');
        $year = $year ?: Carbon::now()->format('Y');

        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth()->toDateString();
        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth()->toDateString();

        $workingTimes = WorkingTime::whereBetween('date_checkin', [$startOfMonth, $endOfMonth])->get();

        $lateCheckins = [];


        $workingTimes->each(function ($workingTime) use (&$lateCheckins) {
            $user = $workingTime->user;
            $checkInTime = $workingTime->time_checkin ? Carbon::parse($workingTime->time_checkin) : null;
            $workStartTime = Carbon::parse($workingTime->date_checkin . ' 08:00:00'); // Corrected to add a space

            if ($checkInTime && $checkInTime->gt($workStartTime)) {
                $minutesLate = $checkInTime->diffInMinutes($workStartTime);

                if (!isset($lateCheckins[$user->id])) {
                    $lateCheckins[$user->id] = [
                        'user_id' => $user->id,
                        'user' => $user->name,
                        'late_count' => 0,
                        'quantity_send_email' => $user->quantity_send_email,
                        'total_late_minutes' => 0,
                    ];
                }
                $lateCheckins[$user->id]['late_count']++;
                $lateCheckins[$user->id]['total_late_minutes'] += $minutesLate;
            }
        });

        $sortedLateCheckins = array_values($lateCheckins);
        $lateCounts = array_column($sortedLateCheckins, 'late_count');
        array_multisort($lateCounts, SORT_DESC, $sortedLateCheckins);

        return response()->json($sortedLateCheckins);
    }
}