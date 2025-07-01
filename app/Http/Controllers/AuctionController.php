<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    /**
     * Display a listing of active auctions.
     */
    public function index()
    {
        $auctions = Auction::where('is_active', true)
            ->where('end_time', '>', now()) // Only show auctions that haven't ended
            ->with('book') // Eager load the book relationship
            ->latest('start_time')
            ->paginate(12);

        return view('auctions.index', compact('auctions'));
    }

    /**
     * Display the specified auction.
     */
    public function show(Auction $auction)
    {
        // Eager load relationships for efficiency
        $auction->load(['book', 'bids.user']);

        $highestBid = $auction->bids->max('bid_amount');

        return view('auctions.show', compact('auction', 'highestBid'));
    }
}