<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            $frontURL = config('app.front_app_url').app()->getLocale().'?email_verify_url='.$url;
            return (new MailMessage())
            ->subject('Please verify your email address')
            ->theme('custom')
            ->markdown('emails.index', ['frontURL' => $frontURL, 'notifiable' => $notifiable]);
        });

        ResetPassword::toMailUsing(function ($notifiable, $url) {
            $email = $notifiable->getEmailForPasswordReset();
            $frontURL = config('app.front_app_url').app()->getLocale().'?reset_token='.$url.'&email='.$email;
            return (new MailMessage())
            ->theme('custom')
            ->subject('Password Reset')
            ->markdown('password-reset.index', ['frontURL' => $frontURL, 'notifiable' => $notifiable]);
        });
    }
}
