<?php

namespace Dskripchenko\LaravelApiUser\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class UserCreated
 * @package Dskripchenko\LaravelApiUser\Notifications
 */
class UserCreated extends \Illuminate\Auth\Notifications\ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     *
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

        $appName = config('api.app.name');
        $appUrl = rtrim(config('api.app.url'), '/');
        $path = trim(config('api.app.urls.user.password.set'), '/');
        $url = "{$appUrl}/{$path}/{$this->token}/{$notifiable->getEmailForPasswordReset()}";

        return (new MailMessage)
            ->subject(trans('Password link'))
            ->line(trans('Registration on the website') . " {$appName}")
            ->action(trans('Set password'), $url)
            ->line(trans('If you did not ask for a password reset, simply ignore this email.'));
    }
}
