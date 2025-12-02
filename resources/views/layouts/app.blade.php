<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

        <style>
            body {
                background-color: #f5f7fa;
                font-family: 'Nunito', sans-serif;
            }

            .navbar {
                background: #ffffff;
                border-bottom: 1px solid #e3e6ea;
                padding-top: 0.7rem;
                padding-bottom: 0.7rem;
            }

            .navbar-brand {
                font-weight: 700;
                font-size: 1.55rem;
                color: #004080 !important;
                letter-spacing: .5px;
            }

            .nav-link {
                font-weight: 500;
                color: #4a5568 !important;
                transition: all .2s;
            }

            .nav-link:hover {
                color: #0056b3 !important;
                transform: translateY(-1px);
            }

            .dropdown-menu {
                border-radius: 10px;
                border: 1px solid #e3e6ea;
                padding: 0.5rem;
            }

            .dropdown-item {
                border-radius: 6px;
                padding: 0.45rem 1rem;
                font-size: 0.95rem;
            }

            .dropdown-item:hover {
                background-color: #f1f4f9;
            }

            .badge {
                font-size: 0.7rem;
                margin-left: 5px;
                padding: 3px 6px;
                border-radius: 50px;
            }

            main {
                padding-top: 30px;
            }
        </style>
    </head>

    <body>
        <div id="app">

            <!-- NAVBAR -->
            <nav class="navbar navbar-expand-md shadow-sm">
                <div class="container">

                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false"
                            aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>


                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <ul class="navbar-nav me-auto"></ul>

                        <!-- RIGHT SIDE -->
                        <ul class="navbar-nav ms-auto">

                            @guest
                            @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="bi bi-box-arrow-in-right"></i> Login
                                </a>
                            </li>
                            @endif

                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    <i class="bi bi-person-plus"></i> Register
                                </a>
                            </li>
                            @endif
                            @else

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('persons.index') }}">
                                    <i class="bi bi-card-text"></i> SSN/DOB
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('orders.index') }}">
                                    <i class="bi bi-bag-check"></i> Orders
                                </a>
                            </li>

                            <!--li class="nav-item">
                                <a class="nav-link" href="{{ route('support.index') }}">
                                    <i class="bi bi-headset"></i> Support
                                </a>
                            </li-->

                            <li class="nav-item">
                                <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                                    <i class="bi bi-cart"></i> Cart
                                    @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
                                    @if($cartCount > 0)
                                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                        {{ $cartCount }}
                                    </span>
                                    @endif
                                </a>
                            </li>


                            <!-- USER DROPDOWN -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">

                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="bi bi-speedometer2"></i> My Account
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right text-danger"></i> Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                </div>
                            </li>

                            @endguest
                        </ul>

                    </div>
                </div>
            </nav>


            <!-- PAGE CONTENT -->
            <main class="py-4">
                @yield('content')
            </main>

        </div>
    </body>
</html>
