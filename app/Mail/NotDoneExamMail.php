<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotDoneExamMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $courses;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $courses)
    {
        $this->user = $user;
        $this->courses = $courses;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = config('const.mail.admin');
        $name = config('const.mail.name');

        return $this->markdown('emails.exam')
                    ->subject(trans('messages.mail.title'))
                    ->from($address, $name)
                    ->with([
                        'user' => $this->user,
                        'courses' => $this->courses,
                    ]);
    }
}
