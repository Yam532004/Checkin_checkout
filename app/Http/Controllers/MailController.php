<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class MailController extends Controller
{
    public function basic_email(Request $request)
    {
        $user_id = $request->input('user_id_send_email');
        $total_check_in_late = $request->input('count_send_email');
        $minutes_check_in_late = $request->input('minutes_send_email');
        $user_name = $request->input('user_name_send_email');
        $month = $request->input('month_send_email');

        // Lấy email của người dùng hiện tại
        $user = User::find($user_id);

        if (!$total_check_in_late) {
            return response()->json(['error' => 'User not found', '$user_id' => $user_id],  404);
        }

        $recipientEmail = $user->email;

        // Tạo dữ liệu để gửi vào email view
        $data = [
            'recipientEmail' => $recipientEmail,
            'total_check_in_late' => $total_check_in_late,
            'minutes_check_in_late' => $minutes_check_in_late,
            'month' => $month,
        ];

        // Gửi email
        Mail::send('mail', $data, function ($message) use ($recipientEmail) {
            $message->to($recipientEmail)
                ->subject('Check Time Reminder');
        });
        return redirect('/admin/dashboard')->with(['message' => 'Email sent successfully', 'user_name'=> $user_name]);
    }



    public function html_email($recipientEmail)
    {
        $data = array('name' => 'Check Time Admin', 'body' => 'This is a test email body.');
        Mail::send('mail', $data, function ($message) use ($recipientEmail) {
            $message->to($recipientEmail)
                ->subject('Check Time Reminder');
        });
        return "HTML Email sent successfully";
    }

    public function attachment_email($recipientEmail)
    {
        $data = array('name' => 'Check Time Admin', 'body' => 'This is a test email body.');
        $file = public_path() . '/attachment.pdf';
        Mail::send('mail', $data, function ($message) use ($recipientEmail, $file) {
            $message->to($recipientEmail)
                ->subject('Check Time Reminder')
                ->attach($file);
        });
        return "Attachment Email sent successfully";
    }
}
