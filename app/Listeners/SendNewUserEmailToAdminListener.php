<?php

namespace App\Listeners;

use App\Events\NewUserCreatedEvent;
use App\Mail\NewUserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendNewUserEmailToAdminListener
{
    /**
     * Handle the event.
     */
    public function handle(NewUserCreatedEvent $event): void
    {
        // Send separate email to admin with all details
        info('admin mail' . $event->user);
        Mail::to('admin@gmail.com')
            ->send(new NewUserCreated($event->user, true));
    }
}
