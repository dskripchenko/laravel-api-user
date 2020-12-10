<?php

namespace Dskripchenko\LaravelApiUser\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class ResetPassword extends \Illuminate\Auth\Notifications\ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(
                static::$toMailCallback,
                $notifiable,
                $this->token
            );
        }

        $appUrl = rtrim(config('api.app.url'), '/');
        $path = trim(config('api.app.urls.user.password.reset'), '/');
        $url = "{$appUrl}/{$path}/{$this->token}/{$notifiable->getEmailForPasswordReset()}";

        return (new MailMessage)
            ->markdown('mail.notification')
            ->subject(trans('Password recovery'))
            ->line(trans('This email has been sent to you because we received a password reset request for your account'))
            ->action(trans('Change password'), $url)
            ->line(trans('If you did not ask for a password reset, simply ignore this email.'));
    }
}
