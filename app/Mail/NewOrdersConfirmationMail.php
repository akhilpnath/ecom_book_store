<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewOrdersConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $order;
    public $isAdmin;

    public function __construct($order, $isAdmin = false)
    {
        $this->order = $order;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        if ($this->isAdmin) {
            return $this->subject('New User Order Confirmation Email - Admin Notification')
                        ->view('admin.email.order_confirmation_admin');
        } else {
            return $this->subject('Welcome to BookStore - Your Order Has Been Placed')
                        ->view('user.email.order_confirmation_user');
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // The subject is already set in build() method, so this is redundant
        // but keeping it for compatibility with Laravel's structure
        return new Envelope(
            subject: $this->isAdmin ? 'New User Order Confirmation Email - Admin Notification' : 'Welcome to BookStore - Your Order Has Been Placed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: $this->isAdmin ? 'admin.email.order_confirmation_admin' : 'user.email.order_confirmation_user',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}