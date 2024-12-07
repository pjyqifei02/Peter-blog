<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mengmeng')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        .content {
            flex: 1; /* Fill remaining height */
        }

        footer {
            background-color: #343a40; 
            color: white; 
            text-align: center;
            padding: 1rem;
            margin-top: auto; /* Ensure footer is always at the bottom */
        }

        .navbar .nav-link {
            color: #ffffff;
        }

        .navbar .nav-link:hover {
            color: #f8f9fa;
        }

        .navbar .navbar-text {
            color: #ffffff;
        }
    </style>
</head>
<body>
    <!-- **Navigation Bar** -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('welcome') }}">Mengmeng</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav d-flex align-items-center mb-2 mb-lg-0">
                    @guest
                        <!-- Guest User -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <!-- Logged In User -->
                        <li class="nav-item me-3">
                            <span class="navbar-text">Welcome, {{ Auth::user()->name }}</span>
                        </li>
                        <li class="nav-item me-3">
                            <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button class="btn btn-link nav-link" type="submit" style="padding: 0;">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- **Content Section** -->
    <div class="content container mt-4">
        @yield('content')
    </div>

    <!-- **Footer Section** -->
    <footer>
        &copy; 2024 Mengmeng Blog. All Rights Reserved.
    </footer>
</body>
</html>
