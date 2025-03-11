<?php

namespace App\Listeners;

use App\Events\NewOrderConfirmaationEvent;
use App\Mail\NewOrdersConfirmationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

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
        // Send email to user
        Mail::to(Auth()->user()->email)->cc('admin@gmail.com')->send(new NewOrdersConfirmationMail($event->order, false));

        // Send email to admin
        Mail::to('admin@gmail.com')->send(new NewOrdersConfirmationMail($event->order, true));
    }
}
