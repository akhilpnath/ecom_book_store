<?php

namespace App\Jobs;

use App\Mail\NewOrdersConfirmationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $order;
    public $userEmail;

    public function __construct($order, $userEmail)
    {
        $this->order = $order;
        $this->userEmail = $userEmail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send email to user
        Mail::to($this->userEmail)->cc('admin@gmail.com')->send(new NewOrdersConfirmationMail($this->order, false));

        // Send email to admin
        Mail::to('admin@gmail.com')->send(new NewOrdersConfirmationMail($this->order, true));
    }
}
