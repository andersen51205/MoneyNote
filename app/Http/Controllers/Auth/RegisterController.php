<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Response
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // 表單驗證
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email|max:255',// unique:users
            'password' => 'required|string|min:8|max:20|confirmed',
            'agree_terms' => 'required',
        ],[
            "name.required" => "使用者名稱 為必填欄位",
            "email.required" => "電子郵件 為必填欄位",
            "email.email" => "電子郵件 格式不正確",
            "email.unique" => "電子郵件 已被註冊",
            "password.required" => "密碼 為必填欄位",
            "password.min" => "密碼至少8個字",
            "password.max" => "密碼最多20個字",
            "password.confirmed" => "確認密碼不相同",
            "agree_terms.required" => "同意服務條款才能註冊帳號"
        ]);
        // 新增使用者
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        // 註冊成功自動登入
        Auth::guard()->login($user);
        // Response
        return response()->json([
            'message' => 'redirect',
            'data' => route('home')
        ], 200);
    }
}
