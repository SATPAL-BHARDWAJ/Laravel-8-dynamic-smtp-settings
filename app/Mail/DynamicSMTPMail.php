<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DynamicSMTPMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user_name, $from;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $user_name, $from )
    {
        $this->user_name = $user_name;
        $this->from = $from;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->from($this->from['email'], $this->from['name'])
                ->subject('Be careful about your smtp settings!')
                ->markdown('emails.dynamic-email');
    }
}
