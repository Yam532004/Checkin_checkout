<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        // Xác thực thông tin đăng nhập
        $request->authenticate();

        // Lấy người dùng đã đăng nhập
        $user = $request->user();

        // Kiểm tra trạng thái và trường deleted_at của người dùng
        if ($user->status == 0 || !is_null($user->deleted_at)) {
            // Đăng xuất người dùng
            Auth::logout();

            // Xóa session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Chuyển hướng về trang đăng nhập với thông báo lỗi
            return redirect('/login')->withErrors(['Your account is either inactive or deleted.']);
        }

        // Tạo lại session sau khi người dùng hợp lệ
        $request->session()->regenerate();

        // Chuyển hướng người dùng đến trang đã được chỉ định
        return redirect()->intended(RouteServiceProvider::redirectTo());
    }


    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
