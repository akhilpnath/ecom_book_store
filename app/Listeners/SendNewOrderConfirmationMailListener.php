<?php

namespace App\Listeners;

use App\Events\NewOrderConfirmaationEvent;
use App\Helpers\ServerLoadHelper;
use App\Jobs\SendOrderConfirmationEmailJob;
use App\Mail\NewOrdersConfirmationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Throwable;
use Illuminate\Support\Facades\Log;

class SendNewOrderConfirmationMailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewOrderConfirmaationEvent $event): void
    {
        try {
            if (ServerLoadHelper::isHighLoad()) {
                // If load is high, offload to queue directly
                Log::info("High load detected — Dispatching to queue directly.");
                SendOrderConfirmationEmailJob::dispatch($event->order, $event->order->email);
            } else {
                // Try event-based processing first
                // Send email to user
                Mail::to(Auth()->user()->email)->cc('admin@gmail.com')->send(new NewOrdersConfirmationMail($event->order, false));

                // Send email to admin
                Mail::to('admin@gmail.com')->send(new NewOrdersConfirmationMail($event->order, true));
            }
        } catch (Throwable $e) {
            // If event fails, push to queue as fallback
            Log::error("Event-based email failed: {$e->getMessage()}. Dispatching to queue.");
            SendOrderConfirmationEmailJob::dispatch($event->order, $event->order->email);
        }
    }

}
