<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Active Auctions</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f9; padding: 20px; }
        .container { max-width: 1200px; margin: auto; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow: hidden; }
        .card img { width: 100%; height: 200px; object-fit: cover; }
        .card-content { padding: 15px; }
        .card-content h3 { margin-top: 0; }
        .card-content a { text-decoration: none; color: #28a745; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Active Auctions</h1>
        <div class="grid">
            @forelse ($auctions as $auction)
                <div class="card">
                    <img src="{{ $auction->book->cover_image }}" alt="Cover of {{ $auction->book->title }}">
                    <div class="card-content">
                        <h3>{{ $auction->book->title }}</h3>
                        <p>by {{ $auction->book->author }}</p>
                        <p>Ends: {{ \Carbon\Carbon::parse($auction->end_time)->format('F j, Y g:i A') }}</p>
                        <a href="{{ route('auctions.show', $auction) }}">View Details & Bid</a>
                    </div>
                </div>
            @empty
                <p>There are no active auctions at the moment. Please check back later!</p>
            @endforelse
        </div>
        <div style="margin-top: 20px;">
            {{ $auctions->links() }}
        </div>
    </div>
</body>
</html>