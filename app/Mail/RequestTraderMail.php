<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestTraderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    public $subjectValue;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData, $subject)
    {
        $this->mailData= $mailData;
        $this->subjectValue = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subjectValue)->view('request-trader-mail-email');
    }
}
