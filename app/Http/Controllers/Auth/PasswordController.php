<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

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
        // Response
        return view('auth.passwords.reset', [
            'token' => $token
        ]);
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        // 表單驗證
        $validated = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:20|confirmed',
        ], [
            'email.required' => '電子郵件 為必填欄位',
            'email.email' => '電子郵件 格式不正確',
            'password.required' => '密碼 為必填欄位',
            'password.min' => '密碼至少8個字',
            'password.max' => '密碼最多20個字',
            'password.confirmed' => '確認密碼不相同',
        ]);
        // 密碼重設
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, $password) {
                // 更新密碼
                $user->password = Hash::make($password);
                $user->remember_token = NULL;
                $user->save();
            }
        );
        // 回傳資料
        $json = [];
        if($status === 'passwords.reset') {
            $code = 200;
            $json['message'] = '密碼重設成功，請使用新密碼登入';
            $json['redirect'] = route('login');
        }
        elseif($status === 'passwords.token') {
            $code = 422;
            $json['message'] = '重設密碼已過期，請重新發送密碼重設信';
        }
        elseif($status === 'passwords.user') {
            $code = 404;
            $json['message'] = '電子郵件 輸入錯誤';
        }
        else {
            $code = 500;
            $json['message'] = '發生錯誤，請稍候再試';
        }
        // Response
        return response()->json($json, $code);
    }
}
