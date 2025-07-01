<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Auction;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    /**
     * Show the form for creating a new auction.
     */
    public function create(Book $book)
    {
        return view('admin.auctions.create', compact('book'));
    }

    /**
     * Store a newly created auction in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming data
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'start_price' => 'required|numeric|min:0.01',
            'start_time' => 'required|date|after_or_equal:now',
            'end_time' => 'required|date|after:start_time',
        ]);

        // 2. Find the book and check its status
        $book = Book::findOrFail($request->book_id);
        if ($book->status !== 'available') {
            return redirect()->route('admin.dashboard')->with('error', 'This book is not available for auction.');
        }

        // 3. Create the auction
        Auction::create([
            'book_id' => $book->id,
            'start_price' => $request->start_price,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        // 4. Update the book's status to 'auctioned'
        $book->status = 'auctioned';
        $book->save();

        // 5. Redirect back with a success message
        return redirect()->route('admin.dashboard')->with('success', 'Auction for "' . $book->title . '" has been created successfully!');
    }

    /**
     * Manually close an auction and declare a winner.
     * THIS IS THE NEW METHOD
     */
    public function close(Auction $auction)
    {
        // Find the highest bid for this auction
        $highestBid = $auction->bids()->orderBy('bid_amount', 'desc')->first();

        if ($highestBid) {
            // If there's a bid, we have a winner
            $auction->winner_id = $highestBid->user_id;
            $auction->book->status = 'sold';
        } else {
            // If there are no bids, the book becomes available again
            $auction->winner_id = null;
            $auction->book->status = 'available';
        }

        // Mark the auction as inactive
        $auction->is_active = false;

        // Save the changes to the auction and the book
        $auction->save();
        $auction->book->save();
        
        // Note: This is where you would trigger notifications to the winner and other bidders.

        return redirect()->route('admin.dashboard')->with('success', 'Auction #' . $auction->id . ' has been closed.');
    }
}