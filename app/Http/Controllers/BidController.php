<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    /**
     * Store a newly created bid in storage.
     */
    public function store(Request $request, Auction $auction)
    {
        // 1. Get the current highest bid or the starting price
        $highestBid = $auction->bids->max('bid_amount') ?? $auction->start_price;

        // 2. Validate the incoming bid
        $request->validate([
            'bid_amount' => 'required|numeric|gt:' . $highestBid,
        ]);

        // 3. Check if the auction is still active
        if (!$auction->is_active || now()->gt($auction->end_time)) {
            return back()->with('error', 'This auction has ended.');
        }

        // 4. Create the new bid
        $auction->bids()->create([
            'user_id' => Auth::id(),
            'bid_amount' => $request->bid_amount,
        ]);

        // Note: This is where you would trigger notifications for outbid users.

        return back()->with('success', 'Your bid has been placed successfully!');
    }
}