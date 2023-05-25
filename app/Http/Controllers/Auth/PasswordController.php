<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function forgotForm()
    {
        // Response
        return view('auth.passwords.forgot');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendEmail(Request $request)
    {
        // 表單驗證
        $validated = $request->validate([
            'email' => 'required|string|email'
        ],[
            'email.required' => '電子郵件 為必填欄位',
            'email.email' => '電子郵件 格式不正確'
        ]);
        /**
         * 寄送密碼重設信
         * expireTime   -> config('auth.passwords.users.expire')
         * throttleTime -> config('auth.passwords.users.throttle')
         */
        $status = Password::sendResetLink(
            $request->only('email')
        );
        // 回傳資料
        if($status === 'passwords.user') {
            $code = 404;
            $message = '此電子郵件尚未註冊';
        }
        elseif($status === 'passwords.sent') {
            $code = 200;
            $message = '密碼重設信已發送';
        }
        elseif($status === 'passwords.throttled') {
            $code = 429;
            $message = '發送太過頻繁，請稍後再試';
        }
        else {
            $code = 500;
            $message = '發生錯誤，請稍候再試';
        }
        // Response
        return response()->json([
            'message' => $message,
        ], $code);
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resetForm(Request $request, $token)
    {
        dd($token);
    }
}
