<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class PHPMailerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PHPMailer::class, function () {
            $phpmailer   = new PHPMailer(true);
            $phpmailer->isSMTP();
            $phpmailer->Host = config('mail.host');
            $phpmailer->SMTPAuth = true;
            $phpmailer->Username = config('mail.username');
            $phpmailer->Password = config('mail.password');
            $phpmailer->SMTPSecure = config('mail.encryption');
            $phpmailer->Port = config('mail.port');
            $phpmailer->setFrom(config('mail.from.address'), config('mail.from.name'));

            return $phpmailer;
        });
    }
}
