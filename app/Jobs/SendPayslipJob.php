<?php

namespace App\Jobs;

use App\Models\User;
use App\Mail\PayslipEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class SendPayslipJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $employee;
    public $tries = 3;
    public $backoff = 10;

    public function __construct(User $employee)
    {
        $this->employee = $employee;
    }

    public function handle(): void
    {
        $pdf = PDF::loadView('pdf.payslip', ['employee' => $this->employee]);

        $pdfContent = $pdf->output();

        Mail::to($this->employee->email)->send(new PayslipEmail($this->employee, $pdfContent));
    }
}
