<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Auction Platform</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap');

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa; /* Lighter gray background */
        }

        .login-box {
            text-align: center;
            background: white;
            padding: 2.5rem 3rem; /* More padding */
            border-radius: 12px; /* More rounded corners */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* Softer shadow */
            max-width: 400px;
            width: 90%;
        }

        .login-box h1 {
            font-size: 1.75rem;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .login-box p {
            color: #718096;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        .google-btn {
            display: inline-flex; /* Use flexbox for alignment */
            align-items: center;
            justify-content: center;
            gap: 0.75rem; /* Space between logo and text */
            background: white;
            color: #4a5568;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            margin-bottom: 1.5rem;
            transition: background-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .google-btn:hover {
            background-color: #f7fafc;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .google-btn svg {
            width: 18px;
            height: 18px;
        }

        .admin-link a {
            font-size: 0.875rem;
            color: #718096;
            text-decoration: none;
        }
        .admin-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Book Auction Platform</h1>
        <p>Please log in or register with your Google account to continue.</p>
        
        <a href="{{ route('socialite.redirect', 'google') }}" class="google-btn">
            <!-- Google Logo SVG -->
            <svg viewBox="0 0 48 48">
                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                <path fill="none" d="M0 0h48v48H0z"></path>
            </svg>
            <span>Login with Google</span>
        </a>
        
        <div class="admin-link">
            <a href="{{ route('login') }}">Admin Login</a>
        </div>
    </div>
</body>
</html>
