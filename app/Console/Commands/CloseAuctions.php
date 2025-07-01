<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;

class CloseAuctions extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'auctions:close';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Find and close auctions whose end time has passed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for auctions to close...');

        // Find all active auctions where the end_time is in the past
        $expiredAuctions = Auction::where('is_active', true)
                                  ->where('end_time', '<=', now())
                                  ->get();

        if ($expiredAuctions->isEmpty()) {
            $this->info('No auctions to close.');
            return;
        }

        foreach ($expiredAuctions as $auction) {
            $highestBid = $auction->bids()->orderBy('bid_amount', 'desc')->first();

            if ($highestBid) {
                $auction->winner_id = $highestBid->user_id;
                $auction->book->status = 'sold';
            } else {
                $auction->winner_id = null;
                $auction->book->status = 'available';
            }

            $auction->is_active = false;
            $auction->save();
            $auction->book->save();

            $this->info("Auction #{$auction->id} for '{$auction->book->title}' has been closed.");
        }

        $this->info('All expired auctions have been processed.');
    }
}