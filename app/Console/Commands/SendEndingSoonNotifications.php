<?php

namespace App\Console\Commands;

use App\Models\Auction;
use App\Notifications\AuctionEndingSoon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendEndingSoonNotifications extends Command
{
    /**
     * The name and signature of the console command.
     * We'll use a consistent naming scheme for our auction commands.
     * @var string
     */
    protected $signature = 'auctions:notify-ending-soon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finds auctions ending within 24 hours and sends reminder notifications to bidders.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for auctions ending soon...');

        // Find auctions that are active, ending in the next 24 hours,
        // and for which we haven't already sent a reminder.
        $auctions = Auction::where('is_active', true)
            ->where('ending_soon_notification_sent', false)
            ->where('end_time', '<', now()->addHours(24))
            ->where('end_time', '>', now())
            ->with('bids.user') // Eager load bids and their users for efficiency
            ->get();

        if ($auctions->isEmpty()) {
            $this->info('No auctions require an "ending soon" notification at this time.');
            return;
        }

        $this->info("Found {$auctions->count()} auctions to notify...");

        foreach ($auctions as $auction) {
            // Get a unique list of all users who have placed a bid on this auction.
            // The ->unique('id') prevents sending multiple emails to a user who bid multiple times.
            $bidders = $auction->bids->map(function ($bid) {
                return $bid->user;
            })->unique('id');

            if ($bidders->isNotEmpty()) {
                // Send the notification to all unique bidders at once.
                Notification::send($bidders, new AuctionEndingSoon($auction));
                $this->info("Sent " . $bidders->count() . " notifications for Auction #{$auction->id}.");
            }

            // IMPORTANT: Mark this auction so we don't send reminders for it again.
            $auction->ending_soon_notification_sent = true;
            $auction->save();
        }

        $this->info('Finished sending all "ending soon" notifications.');
    }
}