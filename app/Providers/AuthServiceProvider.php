<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            $frontURL = 'http://localhost:3000?email_verify_url='.$url;
            return (new MailMessage())
            ->subject('Please verify your email address')
            ->theme('custom')
            ->markdown('emails.index', ['frontURL' => $frontURL, 'notifiable' => $notifiable]);
        });
    }
}
