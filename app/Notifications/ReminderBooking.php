<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReminderBooking extends Notification implements ShouldQueue
{
    use Queueable;
    public $booking;

    /**
     * Create a new notification instance.
     *
     * @param $booking
     */
    public function __construct($booking)
    {
        $this->booking = $booking;

//        Carbon::parse($booking->start_date)->subDays(3);

//        $this->delay(Carbon::parse($booking->start_date))->subDays(3);
//        $this->delay(Carbon::parse($booking->start_date))->subDay(1);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast','mail'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'booking' => $this->booking,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */

    public function toArray($notifiable)
    {
        return [
            'id' => $this->id,
            'read_at' => null,
            'data' => [
                'booking' => $this->booking,
            ],
        ];
    }

    /**
     * Get the Mail representation of the notification.
     *
     * @param $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->view(
            'site.mail.reminder-booking', ['booking' => $this->booking, 'user' => $notifiable]
        );
    }
}
