<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\model\User;

class PartnerEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $requestingUser;
    public $confirmingUser;
    public $subjectValue;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($requestingUser, $confirmingUser, $subject)
    {
        $this->requestingUser = $requestingUser;
        $this->confirmingUser = $confirmingUser;
        $this->subjectValue = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subjectValue)->view('partner-email');
    }
}
