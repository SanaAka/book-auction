<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Start New Auction</title>
    <style>
        body { font-family: sans-serif; padding: 40px; }
        .form-container { max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn { background-color: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; }
        .alert-danger { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Start Auction for: <em>{{ $book->title }}</em></h2>
        <p>by {{ $book->author }}</p>

        <hr>

        @if ($errors->any())
            <div class="alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.auctions.store') }}" method="POST">
            @csrf <input type="hidden" name="book_id" value="{{ $book->id }}">

            <div class="form-group">
                <label for="start_price">Start Price ($)</label>
                <input type="number" name="start_price" id="start_price" value="{{ old('start_price', $book->start_price) }}" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="datetime-local" name="start_time" id="start_time" value="{{ old('start_time') }}" required>
            </div>

            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="datetime-local" name="end_time" id="end_time" value="{{ old('end_time') }}" required>
            </div>

            <button type="submit" class="btn">Create Auction</button>
        </form>
    </div>

</body>
</html>