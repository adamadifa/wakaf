<?php

namespace App\Mail;

use App\Models\InfaqTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InfaqPaymentInstructionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;

    public function __construct(InfaqTransaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Instruksi Pembayaran Infaq - ' . $this->transaction->invoice_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.infaq_payment_instruction',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
