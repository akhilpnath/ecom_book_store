<?php

namespace App\Listeners;

use App\Events\NewUserCreatedEvent;
use App\Mail\NewUserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendNewUserEmailListener
{

    /**
     * Handle the event.
     */
    public function handle(NewUserCreatedEvent $event): void
    {
        // Send email to the user
        info('user mail' . $event->user);
        Mail::to($event->user->email)
            ->send(new NewUserCreated($event->user, false));
    }
}
