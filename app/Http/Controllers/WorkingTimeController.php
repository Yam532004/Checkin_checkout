<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkingTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

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
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $user_created_at = Carbon::parse($user->created_at)->toDateString();
        $workingTime = WorkingTime::where('user_id', $user_id)->where('date_checkin', $today)->first();

        if ($today == $user_created_at) {
            return response()->json(["status" => "user_created_at", "message"  => "You can check in for the next day. Have a good day!"]);
        } else {
            if ($workingTime->time_checkin && !$workingTime->time_checkout) {
                $time_checkin = Carbon::parse($workingTime->time_checkin);
                $day = $time_checkin->format('d/m/Y');
                $time = $time_checkin->format('H:i:s');
                $status = $time > '08:00:00' ? 'Late' : 'Early';
                return response()->json([
                    'status' => 'checked_in',
                    'message' => 'You are currently checked in.',
                    'time' => $time,
                    'day' => $day,
                    'status_check_in' => $status
                ]);
            }
            if ($workingTime->time_checkout) {
                $time_checkout = Carbon::parse($workingTime->time_checkout);
                $day = $time_checkout->format('d/m/Y');
                $time = $time_checkout->format('H:i:s');
                $status = $time < '17:30:00' ?  'Early' : 'Late';
                return response()->json([
                    'status' => 'checked_out',
                    'message' => 'You have already checked out.',
                    'time' => $time,
                    'day' => $day,
                    'status_check_in' => $status
                ]);
            }
            return response()->json(['status' => 'not_working', 'message' => 'No working record found for today.']);
        }
    }


    public function checkIn()
    {
        $user_id = Auth::id();
        $today = Carbon::today()->toDateString();
        $user = Auth::user();
        $user_role = $user->role;

        if ($user_role == 'admin') {
            return response()->json(['status' => 'failed', 'message' => 'You are an Admin. Therefore, you are not allowed to check in.']);
        }

        // Kiểm tra ngày trong tuần
        $dayOfWeek = Carbon::now()->dayOfWeek;
        if ($dayOfWeek == Carbon::SATURDAY || $dayOfWeek == Carbon::SUNDAY) {
            return response()->json(['status' => 'failed', 'message' => 'No working record found for today.']);
        }

        // Tìm kiếm bản ghi check-in
        $workingTime = WorkingTime::where([
            'user_id' => $user_id,
            'date_checkin' => $today
        ])->first();

        if ($workingTime) {
            if (!$workingTime->time_checkin) {
                $workingTime->update([
                    'time_checkin' => Carbon::now('Asia/Ho_Chi_Minh')
                ]);
                $day = $workingTime->time_checkin->format('d/m/Y');
                $time = $workingTime->time_checkin->format('H:i:s');
                $status = $time > '08:00:00' ? 'Late' : 'Early';
                return response()->json([
                    'status' => 'success',
                    'message' => 'Check-in successful.',
                    'time' => $time,
                    'day' => $day,
                    'status_check_in' => $status
                ]);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Already checked in today.']);
            }
        } else {
            $workingTime = new WorkingTime();
            $workingTime->user_id = $user_id;
            $workingTime->date_checkin = $today;
            $workingTime->time_checkin = Carbon::now('Asia/Ho_Chi_Minh');
            $workingTime->save();

            $day = $workingTime->time_checkin->format('d/m/Y');
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

        // Ngay bat dau va ket thuc cua thang 
        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth();

        if ($month == Carbon::now()->format('m') && $year == Carbon::now()->format('Y')) {
            $endOfMonth = Carbon::now();
        }

        // Ngay tao tai khoan nguoi dung 
        $user = User::find($user_id);
        $accountCreationDate = Carbon::parse($user->created_at);
        $startOfMonth = $user ? $accountCreationDate : $startOfMonth;

        // Ngày bắt đầu tính toán là ngày hôm sau của ngày tạo tài khoản nếu ngày tạo tài khoản trước ngày hiện tại
        // if ($accountCreationDate->gt($startOfMonth)) {
        //     $startOfMonth = $accountCreationDate->copy()->addDay();
        // }


        $currentDate = $startOfMonth->copy();
        $dayOfMonth = [];

        while ($currentDate <= $endOfMonth) {
            if ($currentDate->isWeekday()) {
                $dayOfMonth[] = $currentDate->toDateString();
            }
            $currentDate->addDay();
        }
        $workingTimes = WorkingTime::where('user_id', $user_id)
            ->whereBetween('date_checkin', [$startOfMonth, $endOfMonth])
            ->get();

        // Tao danh sach cac ngay da check in
        $checkInDays = $workingTimes->pluck('date_checkin')->map(function ($date) {
            return Carbon::parse($date)->toDateString();
        })->toArray();

        // Tinh ngay vang mat 
        $today = Carbon::today()->toDateString();
        // Xóa ngày hiện tại khỏi danh sách vắng mặt
        if (in_array($today, $dayOfMonth)) {
            $dayOfMonth = array_filter($dayOfMonth, function ($date) use ($today) {
                return $date !== $today;
            });
        }

        $absentDays = array_diff($dayOfMonth, $checkInDays);
        $accountCreationDate = Carbon::parse($user->created_at)->toDateString();
        $absentDays = array_filter($absentDays, function ($date) use ($accountCreationDate) {
            return $date !== $accountCreationDate;
        });


        $report = $workingTimes->map(function ($workingTime) {
            $status = [];
            $checkInTime = $workingTime->time_checkin ? Carbon::parse($workingTime->time_checkin) : null;
            $checkOutTime = $workingTime->time_checkout ? Carbon::parse($workingTime->time_checkout) : null;

            $workStartTime = Carbon::parse($workingTime->date_checkin . ' 08:00:00');
            $workEndTime = Carbon::parse($workingTime->date_checkin . ' 17:30:00');

            if ($checkInTime && $checkInTime->gt($workStartTime)) {
                $status[] = 'Late';
            }
            if ($checkOutTime && $checkOutTime->lt($workEndTime)) {
                $status[] = 'Early';
            }

            return [
                'date' => $workingTime->date_checkin,
                'status' => $status,
                'time_checkin' => $workingTime->time_checkin,
                'time_checkout' => $workingTime->time_checkout,
            ];
        });

        // Tinh ngay check in muon va check out som
        $lateCheckIns = $report->filter(function ($item) {
            return isset($item['status']) && in_array('Late', $item['status']);
        })->values();

        $earlyCheckOuts = $report->filter(function ($item) {
            return isset($item['status']) && in_array('Early', $item['status']);
        })->values();

        return response()->json([
            'report' => $report,
            'absent_days' => $absentDays,
            'late_check_ins' => $lateCheckIns,
            'early_check_outs' => $earlyCheckOuts,
            'user_role' => $user->role,
            'accountCreationDate' => $accountCreationDate,
        ]);
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
            $user = $workingTime->user; // lấy đối tượng user liên kết, vì đã khai báo mối quan hệ giữa các bảng nên $user sẽ chứa tất cả thông tin của user

            // Kiểm tra xem $user có phải là null hay không
            if ($user) {
                // dd($user);
                $userId = $user->id;
                // dd($userId);

                $checkInTime = $workingTime->time_checkin ? Carbon::parse($workingTime->time_checkin) : null;
                $workStartTime = Carbon::parse($workingTime->date_checkin . ' 08:00:00');

                if ($checkInTime && $checkInTime->gt($workStartTime)) {
                    $minutesLate = $checkInTime->diffInMinutes($workStartTime);

                    if (!isset($lateCheckins[$userId])) {
                        $lateCheckins[$userId] = [
                            'user_id' => $userId,
                            'user' => $user->name,
                            'late_count' => 0,
                            'quantity_send_email' => $user->quantity_send_email,
                            'total_late_minutes' => 0,

                        ];
                    }
                    $lateCheckins[$userId]['late_count']++;
                    $lateCheckins[$userId]['total_late_minutes'] += $minutesLate;
                }
            } else {
                // Xử lý trường hợp $user là null, có thể ghi log hoặc bỏ qua
                Log::warning("WorkingTime entry has no associated user: " . $workingTime->id);
            }
        });


        $sortedLateCheckins = array_values($lateCheckins);
        $lateCounts = array_column($sortedLateCheckins, 'late_count');
        array_multisort($lateCounts, SORT_DESC, $sortedLateCheckins);

        return response()->json($sortedLateCheckins);
    }
}
