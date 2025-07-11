<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Auctions</title>
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
            max-width: 1200px;
            margin: auto;
        }

        /* --- Auction Card Grid --- */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .card-image img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-content {
            padding: 1.25rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .card-content h3 {
            margin-top: 0;
            font-size: 1.2rem;
            color: #2d3748;
        }
        .card-content p {
            color: #718096;
            margin: 0.25rem 0;
            font-size: 0.9rem;
        }
        .card-content .action-link {
            display: block;
            text-align: center;
            margin-top: auto; /* Pushes the button to the bottom */
            padding: 0.75rem;
            background-color: #2d3748;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.2s;
        }
        .card-content .action-link:hover {
            background-color: #4a5568;
        }

        /* --- No Auctions Message --- */
        .no-auctions-message {
            text-align: center;
            padding: 3rem;
            background-color: #fff;
            border-radius: 8px;
        }

        /* --- Pagination Styles --- */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin-top: 2rem;
        }
        .page-item { margin: 0 3px; }
        .page-item .page-link, .page-item span {
            display: block;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            color: #4a5568;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
        }
        .page-item .page-link:hover { background-color: #e2e8f0; border-color: #cbd5e0; }
        .page-item.active .page-link {
            z-index: 1;
            color: #fff;
            background-color: #4a5568;
            border-color: #4a5568;
        }
        .page-item.disabled span {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
            opacity: 0.6;
        }
    </style>
</head>
<body>

    <header class="header">
        <h1>Active Auctions</h1>
        <nav class="header-nav">
            @auth
                <a href="{{ route('dashboard') }}">My Dashboard</a>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </nav>
    </header>

    <main class="container">
        <div class="grid">
            @forelse ($auctions as $auction)
                <div class="card">
                    <div class="card-image">
                        <img src="{{ $auction->book->cover_image }}" alt="Cover of {{ $auction->book->title }}">
                    </div>
                    <div class="card-content">
                        <h3>{{ $auction->book->title }}</h3>
                        <p>by {{ $auction->book->author }}</p>
                        <p><strong>Ends:</strong> {{ \Carbon\Carbon::parse($auction->end_time)->format('F j, Y g:i A') }}</p>
                        <a href="{{ route('auctions.show', $auction) }}" class="action-link">View Details & Bid</a>
                    </div>
                </div>
            @empty
                <div class="no-auctions-message">
                    <h2>No Active Auctions</h2>
                    <p>There are no active auctions at the moment. Please check back later!</p>
                </div>
            @endforelse
        </div>

        @if ($auctions->hasPages())
            <div class="pagination">
                {{ $auctions->links() }}
            </div>
        @endif
    </main>

</body>
</html>
