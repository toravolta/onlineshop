<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderResume extends Mailable
{
    use Queueable, SerializesModels;

    public $html_table;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($html_table)
    {
        $this->html_table = $html_table;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Online Shopp Notification')
            ->view('emails.order-resume');
    }
}
