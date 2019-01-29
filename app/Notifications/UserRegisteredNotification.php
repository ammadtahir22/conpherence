<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;

class UserRegisteredNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $token;

    /**
     * ResetPassword constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
//        return (new MailMessage)
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', url('/'))
//                    ->line('Thank you for using our application!');

        $url = url(config('app.url').route('user.activate', ['token' => $this->token, 'user_id' => $notifiable->id], false));

        $email[] = $notifiable->email;

        Mail::send('mail.sign-up', function($message,$email){
            $message->from('testmail@gg.lv');
            $message->subject('welcome');
            $message->to($email);
        });

        return (new MailMessage)
            ->from('info@conpherence.com', 'Admin')
            ->replyTo($notifiable->email)
            ->markdown('site.mail.sign-up', ['url' => $url, 'notifiable' => $notifiable]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
