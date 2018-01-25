<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Track and manage all your expenses, income, and budgets.">
    <meta name="author" content="Muhammad Jawaid Shamshad">
    <link rel="icon" href="favicon.ico">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ibexpenses') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

        @include('layouts.nav')

        <div class="container-fluid">
            <div class="row-fluid">

                @if (!Auth::guest())
                    @include('layouts.sidenav')
                @endif

                <div class="col-md-10">
                    <div class="panel panel-default">
                        
                        <div class="panel-heading">{{ $page_title ?? "" }}</div>

                        <div class="panel-body">
                            @yield('content')
                        </div>

                    </div>  
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
