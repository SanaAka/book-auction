<?php

namespace App\Notifications;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AuctionEndingSoon extends Notification
{
    use Queueable;

    protected Auction $auction;

    /**
     * Create a new notification instance.
     * We pass in the specific auction so the notification knows what it's about.
     */
    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    /**
     * Get the notification's delivery channels.
     * We only need the 'mail' channel for this notification.
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     * This method builds the actual email message.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Generate a URL that will take the user directly to the auction page.
        $url = route('auctions.show', $this->auction);

        return (new MailMessage)
                    ->subject('Auction Ending Soon: ' . $this->auction->book->title)
                    ->greeting('Hi ' . $notifiable->name . ',')
                    ->line('This is a reminder that the auction for "' . $this->auction->book->title . '" is ending in less than 24 hours.')
                    ->line('Don\'t miss your chance to place a final bid and win!')
                    ->action('View Auction', $url);
    }
}