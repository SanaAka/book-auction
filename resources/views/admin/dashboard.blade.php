<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            background-color: #2d3748;
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            margin: 0;
            font-size: 1.5rem;
        }
        .header .logout-btn {
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

        /* --- Form Elements --- */
        .search-form {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        .search-form input[type="text"] {
            flex-grow: 1;
            padding: 0.5rem;
            border: 1px solid #cbd5e0;
            border-radius: 5px;
        }
        .search-form button, .action-form button {
            background-color: #4a5568;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .action-form button { background-color: #4299e1; }

        /* --- Table Styles --- */
        .table-wrapper { overflow-x: auto; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 0.75rem;
            text-align: left;
            vertical-align: middle;
        }
        th { background-color: #edf2f7; }
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
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.375rem;
            color: white;
        }
        .status-available { background-color: #38a169; }
        .status-auctioned { background-color: #dd6b20; }
        .status-sold { background-color: #e53e3e; }

        /* --- Alerts --- */
        .alert { padding: 1rem; margin-bottom: 1.5rem; border: 1px solid transparent; border-radius: 5px; }
        .alert-success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; }
        .alert-danger { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; }
        
        /* === PAGINATION STYLES (UPDATED) === */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin-top: 2rem;
        }
        .page-item {
            margin: 0 3px;
        }
        .page-item .page-link,
        .page-item span { /* Target both links and the '...' span */
            display: block;
            padding: 0.5rem 0.75rem; /* This controls the button size */
            font-size: 0.875rem; /* Smaller font size */
            color: #4a5568;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
        }
        .page-item .page-link:hover {
            background-color: #e2e8f0;
            border-color: #cbd5e0;
        }
        .page-item.active .page-link {
            z-index: 1;
            color: #fff;
            background-color: #4a5568;
            border-color: #4a5568;
        }
        .page-item.disabled span { /* Style for disabled 'previous'/'next' arrows */
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
            opacity: 0.6;
        }
        /* ==================================== */

    </style>
</head>
<body>

    <header class="header">
        <h1>Admin Dashboard</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </header>

    <main class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <h2>Book Management</h2>
            <form action="{{ route('admin.dashboard') }}" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Search by title..." value="{{ request('search') }}">
                <button type="submit">Search</button>
            </form>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td><span class="badge status-{{ $book->status }}">{{ ucfirst($book->status) }}</span></td>
                            <td>
                                @if ($book->status == 'available')
                                    <a href="{{ route('admin.auctions.create', $book) }}">Start Auction</a>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5">No books found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination">
                {{ $books->appends(request()->except('auctionsPage'))->links() }}
            </div>
        </div>

        <div class="card">
            <h2>Auction Management</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Book Title</th>
                            <th>End Time</th>
                            <th>Status</th>
                            <th>Highest Bid</th>
                            <th>Winner</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($auctions as $auction)
                        <tr>
                            <td>{{ $auction->id }}</td>
                            <td>{{ $auction->book->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($auction->end_time)->format('F j, Y g:i A') }}</td>
                            <td>
                                @if ($auction->is_active && $auction->end_time > now())
                                    <span class="badge" style="background-color: #38a169;">Active</span>
                                @elseif ($auction->is_active && $auction->end_time <= now())
                                    <span class="badge" style="background-color: #dd6b20;">Pending Closure</span>
                                @else
                                    <span class="badge" style="background-color: #718096;">Closed</span>
                                @endif
                            </td>
                            <td>${{ number_format($auction->bids->max('bid_amount') ?? 0, 2) }}</td>
                            <td>{{ $auction->winner->name ?? 'N/A' }}</td>
                            <td>
                                @if ($auction->is_active)
                                    <form action="{{ route('admin.auctions.close', $auction) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="action-form">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit">Close Now</button>
                                    </form>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7">No auctions found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination">
                {{ $auctions->appends(request()->except('booksPage'))->links() }}
            </div>
        </div>
    </main>

</body>
</html>