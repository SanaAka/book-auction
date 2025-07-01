<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard</title>
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
        .header-nav .logout-btn {
            background-color: #e53e3e;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .container {
            padding: 1.5rem;
        }

        /* --- Card Containers --- */
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .card h2 {
            margin-top: 0;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 0.75rem;
            font-size: 1.25rem;
        }

        /* --- Table Styles --- */
        .table-wrapper { overflow-x: auto; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }
        th, td {
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem;
            text-align: left;
            vertical-align: middle;
        }
        th { background-color: #edf2f7; color: #718096; font-size: 0.75rem; text-transform: uppercase;}
        tbody tr:hover { background-color: #f7fafc; }
        td a { color: #3182ce; text-decoration: none; font-weight: bold; }
        td a:hover { text-decoration: underline; }

        /* --- Status Badges --- */
        .badge {
            display: inline-block;
            padding: 0.25em 0.6em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            border-radius: 0.375rem;
            color: white;
        }
        .status-winning { background-color: #38a169; }
        .status-outbid { background-color: #dd6b20; }
        .status-won { background-color: #4299e1; }

    </style>
</head>
<body>

    <header class="header">
        <h1>My Dashboard</h1>
        <nav class="header-nav">
            <a href="{{ route('auctions.index') }}">Browse Auctions</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </nav>
    </header>

    <main class="container">
        <div class="card">
            <h2>My Active Bids</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Current Highest Bid</th>
                            <th>Your Highest Bid</th>
                            <th>Status</th>
                            <th>Ends On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activeBids as $auction)
                            @php
                                $highestBid = $auction->bids->max('bid_amount');
                                $myHighestBid = $auction->bids->where('user_id', Auth::id())->max('bid_amount');
                            @endphp
                            <tr>
                                <td>{{ $auction->book->title }}</td>
                                <td>${{ number_format($highestBid, 2) }}</td>
                                <td>${{ number_format($myHighestBid, 2) }}</td>
                                <td>
                                    @if ($highestBid == $myHighestBid)
                                        <span class="badge status-winning">Winning</span>
                                    @else
                                        <span class="badge status-outbid">Outbid</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($auction->end_time)->format('F j, Y g:i A') }}</td>
                                <td><a href="{{ route('auctions.show', $auction) }}">View Auction</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6">You have not placed any bids on active auctions.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <h2>My Won Auctions</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Your Winning Bid</th>
                            <th>Auction Ended</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($wonAuctions as $auction)
                            <tr>
                                <td>{{ $auction->book->title }}</td>
                                <td>${{ number_format($auction->bids->max('bid_amount'), 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($auction->end_time)->format('F j, Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3">You have not won any auctions yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>