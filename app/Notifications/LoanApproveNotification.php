<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LoanApprovedNotification extends Notification
{
    use Queueable;

    public function __construct(public $loan) {}

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Loan Approved 🎉')
            ->line('Your loan has been approved.')
            ->line('Amount: $' . number_format($this->loan->amount, 2))
            ->action('View Loan', url('/loans'))
            ->line('Thank you for using our system!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your loan has been approved',
            'loan_id' => $this->loan->id,
        ];
    }
}