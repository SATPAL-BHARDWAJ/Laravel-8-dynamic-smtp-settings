<?php

namespace App\Traits;

use App\Mail\DynamicSMTPMail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Swift_Mailer;
use Swift_SmtpTransport;

trait SmtpConfigTrait {

    public function testSMTP() {
      
        try {
            $user = (object) [
                'name' => 'Harry potter',
                'email' => 'ditro.dev@gmail.com'
            ];

            $configuration = [
                'smtp_host'    => 'smtp.googlemail.com',
                'smtp_port'    => '465',
                'smtp_username'  => 'satpalsharma283@gmail.com',
                'smtp_password'  => 'ielwyxpwwifdjbwt',
                'smtp_encryption'  => 'ssl',
                'from_email'    => 'satpalbhardwaj665@gmail.com',
                'from_name'    => 'Harry - T',
                'replyTo_email'    => 'satpalbhardwaj665@gmail.com',
                'replyTo_name'    => 'Harry Pc',
            ];
           
            //$this->approach1($configuration, $user);
            //$this->approach2($configuration, $user);
            $this->approach3($configuration, $user);

            return true;
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }

    }

    public function approach1($configuration, $user) {
        $mailer = app()->makeWith('custom.smtp.mailer', $configuration);
        $mailer->to( $user->email )->send( new DynamicSMTPMail($user->name, ['email' => $configuration['from_email'], 'name' => $configuration['from_name']]) );
    }

    public function approach2($configuration, $user) {
       
        // backup mailing configuration
        $backup = Mail::getSwiftMailer();

        // set mailing configuration
        $transport = (new Swift_SmtpTransport(
                                $configuration['smtp_host'], 
                                $configuration['smtp_port'], 
                                $configuration['smtp_encryption']))

                    ->setUsername($configuration['smtp_username'])
                    ->setPassword($configuration['smtp_password']);

        $maildoll = new Swift_Mailer($transport);

        // set mailtrap mailer
        Mail::setSwiftMailer($maildoll);

        Mail::to(  $user->email )->send( new DynamicSMTPMail( $user->name, ['email' => $configuration['from_email'], 'name' => $configuration['from_name']] ) );

        // reset to default configuration
        Mail::setSwiftMailer($backup);
    }

    public function approach3($configuration, $user) {
        $backup = Config::get('mail.mailers.smtp');

        Config::set('mail.mailers.smtp.host', $configuration['smtp_host']);
        Config::set('mail.mailers.smtp.port', $configuration['smtp_port']);
        Config::set('mail.mailers.smtp.username', $configuration['smtp_username']);
        Config::set('mail.mailers.smtp.password', $configuration['smtp_password']);
        Config::set('mail.mailers.smtp.encryption', $configuration['smtp_encryption']);
        Config::set('mail.mailers.smtp.transport', 'smtp');
        //Config::set('mail.mailers.smtp.auth_mode', true);
        
        Mail::to(  $user->email )->send(new DynamicSMTPMail( $user->name, ['email' => $configuration['from_email'], 'name' => $configuration['from_name']] ));

        Config::set('mail.mailers.smtp', $backup);
    }
}