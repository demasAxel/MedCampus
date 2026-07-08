<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancellationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cancellationData;

    public function __construct($cancellationData)
    {
        $this->cancellationData = $cancellationData;
    }

    public function build()
    {
        return $this->subject('Pemberitahuan Pembatalan Jadwal MedCampus')
                    ->view('emails.cancellation');
    }
}