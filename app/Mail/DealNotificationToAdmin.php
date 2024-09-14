<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DealNotificationToAdmin extends Mailable
{
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->message = $data->message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email_content = $this->message;

        return $this->view('emails.admin-deal-notification',compact('email_content'));
    }
}
