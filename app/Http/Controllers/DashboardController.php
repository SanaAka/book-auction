<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Auction;


class DashboardController extends Controller
{
    /**
     * Display the user's personalized dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Get IDs of auctions the user has bid on
        $bidOnAuctionIds = $user->bids()->pluck('auction_id')->unique();

        // Get auctions the user has bid on that are still active
        $activeBids = Auction::whereIn('id', $bidOnAuctionIds)
            ->where('is_active', true)
            ->where('end_time', '>', now())
            ->with('book', 'bids')
            ->get();

        // Get auctions the user has won
        $wonAuctions = Auction::where('winner_id', $user->id)
            ->where('is_active', false)
            ->with('book')
            ->get();

        return view('dashboard', compact('activeBids', 'wonAuctions'));
    }
}