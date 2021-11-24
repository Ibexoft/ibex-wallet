<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ibexpenses') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">

        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'ibEXPENSES') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @auth
            <!-- Left Side Of Navbar -->
            <div class="container">
                <ul class="navbar-nav ml-auto mr-auto">
                    <li class="nav-item {{ Request::is('/') ? 'active' : '' }}"><a class="nav-link"
                                                                                   href="/">Dashboard</a></li>
                    <li class="nav-item {{ Request::is('transactions') ? 'active' : '' }}"><a class="nav-link"
                                                                                              href="/transactions">Transactions</a>
                    </li>
                    <li class="nav-item {{ Request::is('accounts') ? 'active' : '' }}"><a class="nav-link"
                                                                                          href="/accounts">Accounts</a>
                    </li>
                    <li class="nav-item {{ Request::is('wallets') ? 'active' : '' }}"><a class="nav-link"
                                                                                         href="/wallets">Wallets</a>
                    </li>
                    <li class="nav-item {{ Request::is('categories') ? 'active' : '' }}"><a class="nav-link"
                                                                                            href="/categories">Income &
                            Expenses</a></li>
                </ul>
            </div>
            @endauth

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
