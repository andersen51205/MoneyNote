<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Response
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        // 表單驗證
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ],[
            "email.required" => "電子郵件 為必填欄位",
            "email.email" => "電子郵件 格式不正確",
            "password.required" => "密碼 為必填欄位",
        ]);
        // 認證帳密
        if (!Auth::attempt($validated)) {
            return response()->json([
                'message' => 'Email不存在或密碼錯誤',
            ], 401);
        }
        // 重新產生sessionID
        $request->session()->regenerate();
        // Response
        return response()->json([
            'redirect' => route('home')
        ], 200);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // 登出使用者
        Auth::logout();
        // 重新產生sessionID並刪除舊資料
        $request->session()->invalidate();
        // 重新產生CSRF Token
        $request->session()->regenerateToken();
        // Response
        return redirect()->route('login.form');
    }    
}
