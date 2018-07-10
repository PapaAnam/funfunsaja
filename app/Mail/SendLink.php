<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLink extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $view_path;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $view_path)
    {
        $this->user = $user;
        $this->view_path = $view_path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verifikasi Akun Anda')->view('mail.'.$this->view_path);
    }
}
