<?php

namespace App\Listeners;

use App\Events\NewUserCreatedEvent;
use App\Mail\NewUserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendNewUserRegisterEmailListener
{

    /**
     * Handle the event.
     */
    public function handle(NewUserCreatedEvent $event): void
    {
        // Send separate email to admin with all details
        Mail::to('admin@gmail.com')
            ->send(new NewUserCreated($event->user, true));

        // Send email to the user
        Mail::to($event->user->email)
            ->send(new NewUserCreated($event->user, false));
    }
}
