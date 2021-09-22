<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Swift_Mailer;
use Swift_SmtpTransport;
use Illuminate\Support\Arr;
use Illuminate\Mail\Mailer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->createSMTPMailer();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function createSMTPMailer() {
        $this->app->bind('custom.smtp.mailer', function ($app, $parameters) {
            $smtp_host = Arr::get($parameters, 'smtp_host');
            $smtp_port = Arr::get($parameters, 'smtp_port');
            $smtp_username = Arr::get($parameters, 'smtp_username');
            $smtp_password = Arr::get($parameters, 'smtp_password');
            $smtp_encryption = Arr::get($parameters, 'smtp_encryption');

            $from_email = Arr::get($parameters, 'from_email');
            $from_name = Arr::get($parameters, 'from_name');

            $replyTo_email = Arr::get($parameters, 'replyTo_email');
            $replyTo_name = Arr::get($parameters, 'replyTo_name');

            $transport = new Swift_SmtpTransport($smtp_host, $smtp_port);
            $transport->setUsername($smtp_username);
            $transport->setPassword($smtp_password);
            $transport->setEncryption($smtp_encryption);

            $swift_mailer = new Swift_Mailer($transport);

            $mailer = new Mailer('custom-smtp-mailer', $app->get('view'), $swift_mailer, $app->get('events'));
            $mailer->alwaysFrom($from_email, $from_name);
            $mailer->alwaysReplyTo($replyTo_email, $replyTo_name);

            return $mailer;
        });
    }
}
