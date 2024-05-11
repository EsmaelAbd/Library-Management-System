<?php

namespace App\Jobs;

use App\Mail\BookBorrowedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;

    /**
     * Create a new job instance.
     */
    public function __construct($email)
    {
        $this->email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email->to)->send(new BookBorrowedNotification($this->email));
    }
}
