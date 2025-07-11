<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction: {{ $auction->book->title }}</title>
    <style>
        /* --- General Body & Typography --- */
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            color: #4a5568;
        }

        /* --- Layout & Header --- */
        .header {
            background-color: #ffffff;
            color: #2d3748;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
        }
        .header h1 {
            margin: 0;
            font-size: 1.5rem;
        }
        .header-nav a {
            color: #4a5568;
            text-decoration: none;
            font-weight: bold;
            margin-left: 1.5rem;
        }
        .container {
            padding: 1.5rem;
            max-width: 960px;
            margin: auto;
        }
        .auction-layout {
            display: grid;
            grid-template-columns: 1fr; /* Single column on mobile */
            gap: 2rem;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        @media (min-width: 768px) { /* Two columns on larger screens */
            .auction-layout {
                grid-template-columns: 1fr 2fr;
            }
        }

        /* --- Book & Auction Details --- */
        .book-cover img {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .auction-details h2 {
            margin-top: 0;
            font-size: 1.75rem;
            color: #2d3748;
        }
        .auction-details h3 {
            margin: 0.25rem 0 1rem 0;
            font-weight: 500;
            color: #718096;
        }
        .auction-details p {
            line-height: 1.6;
        }

        /* --- Bidding Box --- */
        .bidding-box {
            background-color: #ebf8ff;
            border: 1px solid #90cdf4;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            margin: 1.5rem 0;
        }
        .bidding-box .label {
            margin-top: 0;
            color: #2c5282;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.8rem;
        }
        .bidding-box .price {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0.5rem 0 0 0;
            color: #2c5282;
        }

        /* --- Bid Form & Alerts --- */
        .bid-form label { font-weight: bold; display: block; margin-bottom: 0.5rem; }
        .bid-form input[type=number] {
            width: 100%;
            padding: 0.75rem;
            box-sizing: border-box;
            border: 1px solid #cbd5e0;
            border-radius: 5px;
            font-size: 1rem;
        }
        .bid-form button {
            width: 100%;
            padding: 0.8rem;
            background-color: #38a169;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            margin-top: 1rem;
            font-weight: bold;
            transition: background-color 0.2s;
        }
        .bid-form button:hover { background-color: #2f855a; }
        .alert { padding: 1rem; margin-bottom: 1.5rem; border-radius: 5px; border: 1px solid transparent; }
        .alert-success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; }
        .alert-danger { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; }
        .alert ul { margin: 0; padding-left: 1.2rem; }

        /* --- Bidding History --- */
        .bids-history { list-style: none; padding: 0; margin-top: 2rem; }
        .bids-history h4 { border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem; }
        .bids-history li {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .bids-history li:nth-child(odd) { background-color: #f7fafc; }
        .bids-history .bid-user { font-weight: bold; }
        .bids-history .bid-time { font-size: 0.85rem; color: #718096; }

    </style>
</head>
<body>

    <header class="header">
        <h1>Auction Details</h1>
        <nav class="header-nav">
            <a href="{{ route('auctions.index') }}">All Auctions</a>
            @auth
                <a href="{{ route('dashboard') }}">My Dashboard</a>
            @endauth
        </nav>
    </header>

    <main class="container">
        <div class="auction-layout">
            <div class="book-cover">
                <img src="{{ $auction->book->cover_image }}" alt="Cover of {{ $auction->book->title }}">
            </div>
            <div class="auction-details">
                <h2>{{ $auction->book->title }}</h2>
                <h3>by {{ $auction->book->author }}</h3>
                <p>{{ $auction->book->description }}</p>

                <div class="bidding-box">
                    <h3 class="label">CURRENT HIGHEST BID</h3>
                    <p class="price">${{ number_format($highestBid ?? $auction->start_price, 2) }}</p>
                </div>
                
                <div class="bid-form-container">
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
                        <label for="bid_amount">Place Your Bid ($):</label>
                        <input type="number" name="bid_amount" id="bid_amount" step="0.01" placeholder="Enter an amount greater than the current bid" required>
                        <button type="submit">Place Your Bid</button>
                    </form>
                    @else
                    <p>Please <a href="{{ route('login') }}">log in</a> to place a bid.</p>
                    @endauth
                </div>

                <div class="bids-history">
                    <h4>Bidding History</h4>
                    <ul>
                        @forelse($auction->bids->sortByDesc('created_at') as $bid)
                            <li>
                                <div>
                                    <span class="bid-user">{{ $bid->user->name }}</span>
                                    <span class="bid-time"> - {{ $bid->created_at->format('F j, g:i A') }}</span>
                                </div>
                                <strong>${{ number_format($bid->bid_amount, 2) }}</strong>
                            </li>
                        @empty
                            <li>Be the first to bid on this item!</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
