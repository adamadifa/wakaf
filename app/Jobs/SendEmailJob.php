<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $recipient;
    protected $mailable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($recipient, $mailable)
    {
        $this->recipient = $recipient;
        $this->mailable = $mailable;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Mail::to($this->recipient)->send($this->mailable);
        } catch (\Exception $e) {
            Log::error('Failed to send email via Queue: ' . $e->getMessage());
            // Optional: Release the job back to the queue for retry
            // $this->release(10); 
        }
    }
}
