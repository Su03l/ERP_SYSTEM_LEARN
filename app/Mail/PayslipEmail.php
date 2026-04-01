<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PayslipEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee; // 
    public $pdfContent; // 

    public function __construct(User $employee, $pdfContent)
    {
        $this->employee = $employee;
        $this->pdfContent = $pdfContent;
    }

    // هذا يحدد البيانات التي سيتم بثها
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'مسير راتب شهر ' . now()->translatedFormat('F Y'),
        );
    }

    // هذا يحدد البيانات التي سيتم بثها
    public function content(): Content
    {
        return new Content(
            view: 'emails.payslip',
            with: [
                'employee' => $this->employee,
            ],
        );
    }

    // هذا يحدد البيانات التي سيتم بثها
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent, 'Payslip.pdf')
                    ->withMime('application/pdf'),
        ];
    }
}
