<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $paymentData;
    public $status;

    public function __construct($paymentData, $status)
    {
        $this->paymentData = $paymentData;
        $this->status = $status;
    }

    public function build()
    {
        $subject = $this->status === 'success' ? 'Bukti Pembayaran MedCampus' : 'Tagihan Pembayaran MedCampus';
        $view = $this->status === 'success' ? 'emails.payment-success' : 'emails.payment-pending';

        return $this->subject($subject)->view($view);
    }
}