<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Auction; // <-- Import the Auction model

class AdminController extends Controller
{
    /**
     * Show the admin dashboard with lists of books and auctions.
     */
    public function dashboard(Request $request)
    {
        // Logic to get all books and allow searching
        $bookQuery = Book::latest();

        // A cleaner way to check if the search input has a value
        if ($request->filled('search')) {
            $bookQuery->where('title', 'like', '%' . $request->search . '%');
        }

        // We use a custom page name 'booksPage' so its pagination doesn't conflict with the auctions table
        $books = $bookQuery->paginate(15, ['*'], 'booksPage');

        // --- THIS IS THE CORRECTED LOGIC TO FETCH AUCTIONS ---
        // Get all auctions, including their related book, winner, AND BIDS information
        // We use a custom page name 'auctionsPage' for its pagination
        $auctions = Auction::with(['book', 'winner', 'bids']) // <-- 'bids' has been added here
            ->latest()
            ->paginate(15, ['*'], 'auctionsPage');
        // ---------------------------------------------

        // Return the admin dashboard view and pass BOTH books and auctions to it
        return view('admin.dashboard', compact('books', 'auctions'));
    }
}