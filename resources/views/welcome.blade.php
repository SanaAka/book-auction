<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Auction Platform</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f4f4f9; }
        .login-box { text-align: center; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .google-btn { display: inline-block; background: #4285F4; color: white; padding: 12px 24px; border-radius: 4px; text-decoration: none; font-weight: bold; margin-bottom: 20px; }
        .admin-link { font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Book Auction Platform</h1>
        <p>Please log in or register to continue.</p>
        <a href="{{ route('socialite.redirect', 'google') }}" class="google-btn">
            Login with Google
        </a>
        <br>
        <a href="{{ route('login') }}" class="admin-link">Admin Login</a>
    </div>
</body>
</html>