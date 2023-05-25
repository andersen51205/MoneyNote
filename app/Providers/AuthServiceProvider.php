<?php

namespace App\Providers;

use App\Models\User;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // 密碼重設信
        ResetPassword::toMailUsing(function (User $user, string $token) {
            return (new MailMessage)
                ->subject('密碼重設信')
                ->greeting('你好！')
                ->line('你收到這封電子郵件是因為我們收到了你的密碼重設請求。')
                ->action('重設密碼', route('password.reset.form', ['token' => $token]))
                ->line('此密碼重設連結將在 60 分鐘後過期。')
                ->line('如果你沒有要求重設密碼，請忽略這封信。');
        });
    }
}
