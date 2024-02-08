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

    @vite(['resources/sass/app.scss'])
</head>

<body>
<div id="app">

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Dashboard</a>
                        </li>
                        @can('admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.index') }}">Users</a>
                            </li>
                        @endcan
                    </ul>
                @endguest

                <!-- Conditional Rendering based on Authentication -->
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
                                    <img src="{{ asset(auth()->user()->avatar) }}" alt="Avatar" class="rounded-circle"
                                         height="30">
                                    {{ auth()->user()->name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="userDropdown">
                                    <a class="dropdown-item"
                                       href="{{ route('user.view', auth()->user()->id) }}">Profile</a>
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
        @if (Session::has('success'))
            <div id="successMessage" class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        @if (Session::has('error'))
            <div id="errorMessage" class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</div>
<footer>
    <p>This website uses <a href="https://getbootstrap.com/">Bootstrap</a> under the <a
            href="https://opensource.org/licenses/MIT">MIT License</a>.</p>
</footer>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@vite(['resources/js/app.js'])
<script>
    // Hide success message after 5 seconds
    setTimeout(function () {
        $('#successMessage').fadeOut('fast');
    }, 5000);
</script>
@stack('scripts')

</body>

</html>
