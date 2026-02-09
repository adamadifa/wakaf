<?php

namespace App\Mail;

use App\Models\ZakatTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ZakatConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;

    public function __construct(ZakatTransaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Zakat Anda Telah Diterima - ' . $this->transaction->invoice_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.zakat_confirmed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
