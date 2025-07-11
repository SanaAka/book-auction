<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start New Auction</title>
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
            max-width: 640px;
            margin: auto;
        }

        /* --- Form Card --- */
        .form-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2rem;
        }
        .form-header h2 {
            margin-top: 0;
            font-size: 1.25rem;
        }
        .form-header h2 em {
            font-style: normal;
            color: #2d3748;
        }
        .form-header p {
            margin-top: 0.25rem;
            color: #718096;
        }

        /* --- Form Elements --- */
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            box-sizing: border-box;
            border: 1px solid #cbd5e0;
            border-radius: 5px;
            font-size: 1rem;
        }
        .btn-submit {
            width: 100%;
            padding: 0.8rem;
            background-color: #38a169;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            transition: background-color 0.2s;
        }
        .btn-submit:hover {
            background-color: #2f855a;
        }

        /* --- Alerts --- */
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
        }
        .alert-danger ul {
            margin: 0;
            padding-left: 1.2rem;
        }
    </style>
</head>
<body>

    <header class="header">
        <h1>Create Auction</h1>
        <nav class="header-nav">
            <a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
        </nav>
    </header>

    <main class="container">
        <div class="form-card">
            <div class="form-header">
                <h2>Start Auction for: <em>{{ $book->title }}</em></h2>
                <p>by {{ $book->author }}</p>
            </div>

            <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 1.5rem 0;">

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
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">

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

                <button type="submit" class="btn-submit">Create Auction</button>
            </form>
        </div>
    </main>

</body>
</html>