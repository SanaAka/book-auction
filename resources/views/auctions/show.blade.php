<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Auction: {{ $auction->book->title }}</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .container { max-width: 900px; margin: auto; display: grid; grid-template-columns: 1fr 2fr; gap: 40px; }
        .book-cover img { width: 100%; border-radius: 8px; }
        .current-bid { background-color: #d4edda; padding: 20px; border-radius: 8px; text-align: center; }
        .current-bid h3 { margin-top: 0; }
        .current-bid p { font-size: 2em; font-weight: bold; margin: 0; }
        .bid-form input[type=number] { width: 100%; padding: 10px; box-sizing: border-box; }
        .bid-form button { width: 100%; padding: 12px; background-color: #28a745; color: white; border:none; border-radius: 5px; cursor: pointer; font-size: 1.1em; margin-top: 10px; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { color: #155724; background-color: #d4edda; }
        .alert-danger { color: #721c24; background-color: #f8d7da; }
        .bids-history { list-style: none; padding: 0; }
        .bids-history li { background-color: #f8f9fa; padding: 10px; border-bottom: 1px solid #dee2e6; }
    </style>
</head>
<body>
    <div class="container">
        <div class="book-cover">
            <img src="{{ $auction->book->cover_image }}" alt="Cover of {{ $auction->book->title }}">
        </div>
        <div class="auction-details">
            <h1>{{ $auction->book->title }}</h1>
            <h3>by {{ $auction->book->author }}</h3>
            <p>{{ $auction->book->description }}</p>
            <hr>
            <div class="current-bid">
                <h3>CURRENT HIGHEST BID</h3>
                <p>${{ number_format($highestBid ?? $auction->start_price, 2) }}</p>
            </div>
            
            <div style="margin-top: 20px;">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif

                @auth
                <form action="{{ route('bids.store', $auction) }}" method="POST" class="bid-form">
                    @csrf
                    <label for="bid_amount">Your Bid ($):</label>
                    <input type="number" name="bid_amount" id="bid_amount" step="0.01" placeholder="Enter an amount greater than the current bid" required>
                    <button type="submit">Place Your Bid</button>
                </form>
                @else
                <p>Please <a href="{{ route('login') }}">log in</a> to place a bid.</p>
                @endauth
            </div>

            <div style="margin-top: 30px;">
                <h3>Bidding History</h3>
                <ul class="bids-history">
                    @forelse($auction->bids->sortByDesc('created_at') as $bid)
                        <li><strong>${{ number_format($bid->bid_amount, 2) }}</strong> by {{ $bid->user->name }} on {{ $bid->created_at->format('F j, g:i A') }}</li>
                    @empty
                        <li>Be the first to bid on this item!</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</body>
</html>