<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewUserCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    public $isAdmin;
    public function __construct(User $user, bool $isAdmin = false)
    {
        $this->user = $user;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'New User Created',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'admin.email.newuseremail',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return ['https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'];
    // }

    public function build()
    {
        if ($this->isAdmin) {
            return $this->subject('New User Registration - Admin Notification')
                        ->view('admin.email.newuseremail');
                        // ->attachFromStorage('/attachments/welcome-package.pdf');
        } else {
            return $this->subject('Welcome to BookStore - Your Account Has Been Created')
                        ->view('user.email.newuserewelcomemail');
                        // ->attachFromStorage('/attachments/welcome-package.pdf');
        }
    }
}
