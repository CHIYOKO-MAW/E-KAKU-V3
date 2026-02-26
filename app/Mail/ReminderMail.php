<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $type;
    public $user;
    public $kartu;

    public function __construct($type, $user, $kartu = null)
    {
        $this->type = $type;
        $this->user = $user;
        $this->kartu = $kartu;
    }

    public function build()
    {
        $subject = $this->type === 'status_update' ? 'Pengingat: Perbarui Status Pekerjaan' : 'Pengingat: Masa Berlaku Kartu Kuning';
        return $this->subject($subject)
                    ->markdown('emails.reminder')
                    ->with([
                        'type' => $this->type,
                        'user' => $this->user,
                        'kartu' => $this->kartu,
                    ]);
    }
}
