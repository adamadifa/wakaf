<?php

namespace App\Mail;

use App\Models\ZakatTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ZakatPaymentInstructionMail extends Mailable
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
            subject: 'Instruksi Pembayaran Zakat - ' . $this->transaction->invoice_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.zakat_payment_instruction',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
