<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Subscribe extends Mailable
{
    use Queueable, SerializesModels;
    public $subscriber;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subscriber)
    {
        //
        $this->subscribe = $subscriber;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('site.mail.subscribe');
    }
}
