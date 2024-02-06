<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    @vite(['resources/sass/app.scss'])
</head>

<body>
<div id="app">

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- Brand Logo and Name -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="" alt="Logo" height="30" class="d-inline-block align-top">
                {{ config('app.name', 'Laravel') }}
            </a>

            <!-- Responsive Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                @guest
                    <ul class="navbar-nav me-auto">
                    </ul>
                @else
                    {!! Menu::main() !!}
                @endguest

                <!-- Language Dropdown -->
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Language
                        </a>
                        <div class="dropdown-menu" aria-labelledby="languageDropdown">
                            <a class="dropdown-item" href="{{ route('locale', 'en') }}">English</a>
                            <a class="dropdown-item" href="{{ route('locale', 'fr') }}">French</a>
                            <!-- Add more language options as needed -->
                        </div>
                    </li>
                </ul>                    <!-- Conditional Rendering based on Authentication -->
                <div class="d-flex flex-column flex-md-row align-items-center">
                    <!-- If Unauthorized -->
                    @guest
                        <div class="d-flex">
                            <div id="unauthorized" class="mb-2 me-2">
                                @if (Route::has('login'))
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                @endif
                            </div>
                            <div id="unauthorized" class="mb-2">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </div>
                        </div>

                    @else
                        <!-- If Authenticated -->
                        <div id="authenticated" class="mb-2 mb-md-0">
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" id="userDropdown"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar" class="rounded-circle"
                                         height="30">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest
                </div>

            </div>
        </div>
    </nav>

    <!-- Content section -->
    <div class="container py-4">
        @yield('content')
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

@vite(['resources/js/app.js'])
@stack('scripts')
</body>

</html>
