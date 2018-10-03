<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> --}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <!-- Styles -->

    <!-- Icons -->
    <link href="{{ asset('vendor/nucleo/css/nucleo.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    <!-- Argon CSS -->
    <link type="text/css" href="{{ asset('css/argon.min.css') }}" rel="stylesheet"> {{--
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
</head>

<body>
    <div id="app">
        <!-- Sidenav -->
        @include('layouts.sidebar')
        
        <!-- Main content -->
        <div class="main-content">
            <!-- Top navbar -->
            <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
                <div class="container-fluid">
                    <!-- Brand -->
                    <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="./index.html">Dashboard</a>
                    <!-- Form -->
                    <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
                        <div class="form-group mb-0">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input class="form-control" placeholder="Search" type="text">
                            </div>
                        </div>
                    </form>
                    <!-- User -->
                    <ul class="navbar-nav align-items-center d-none d-md-flex">
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                      {{-- <img alt="Image placeholder" src="{{ asset('img/theme/team-1-800x800.jpg') }}"> --}}
                      <i class="ni ni-single-02"></i>
                    </span>
                                    <div class="media-body ml-2 d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold">{{ Auth::user()->name }}</span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome!</h6>
                                </div>
                                <a href="./examples/profile.html" class="dropdown-item">
                    <i class="ni ni-single-02"></i>
                    <span>My profile</span>
                  </a>
                                <a href="./examples/profile.html" class="dropdown-item">
                    <i class="ni ni-settings-gear-65"></i>
                    <span>Settings</span>
                  </a>
                                <a href="./examples/profile.html" class="dropdown-item">
                    <i class="ni ni-calendar-grid-58"></i>
                    <span>Activity</span>
                  </a>
                                <a href="./examples/profile.html" class="dropdown-item">
                    <i class="ni ni-support-16"></i>
                    <span>Support</span>
                  </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                    <i class="ni ni-user-run"></i>
                    <span>{{ __('Logout') }}</span>
                  </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- Header -->
            <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
                <div class="container-fluid">
                    <div class="header-body">
                        <!-- Card stats -->
                        <div class="row">
                            <div class="col-xl-3 col-lg-6">
                                <div class="card card-stats mb-4 mb-xl-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase text-muted mb-0">Traffic</h5>
                                                <span class="h2 font-weight-bold mb-0">350,897</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                                    <i class="fas fa-chart-bar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-3 mb-0 text-muted text-sm">
                                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                            <span class="text-nowrap">Since last month</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6">
                                <div class="card card-stats mb-4 mb-xl-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase text-muted mb-0">New users</h5>
                                                <span class="h2 font-weight-bold mb-0">2,356</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                                    <i class="fas fa-chart-pie"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-3 mb-0 text-muted text-sm">
                                            <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span>
                                            <span class="text-nowrap">Since last week</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6">
                                <div class="card card-stats mb-4 mb-xl-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase text-muted mb-0">Sales</h5>
                                                <span class="h2 font-weight-bold mb-0">924</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                                    <i class="fas fa-users"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-3 mb-0 text-muted text-sm">
                                            <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                                            <span class="text-nowrap">Since yesterday</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6">
                                <div class="card card-stats mb-4 mb-xl-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase text-muted mb-0">Performance</h5>
                                                <span class="h2 font-weight-bold mb-0">49,65%</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                                    <i class="fas fa-percent"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-3 mb-0 text-muted text-sm">
                                            <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                                            <span class="text-nowrap">Since last month</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page content -->
            <div class="container-fluid mt--7">

                @yield('content')

                <!-- Footer -->
                <footer class="footer">
                    <div class="row align-items-center justify-content-xl-between">
                        <div class="col-xl-6">
                            <div class="copyright text-center text-xl-left text-muted">
                                &copy; 2019 <a href="https://www.ibexoft.com" class="font-weight-bold ml-1" target="_blank">Ibexoft</a>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
                                </li>
                                <li class="nav-item">
                                    <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md" class="nav-link" target="_blank">MIT License</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Core -->
    <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
    {{--
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script> --}}

    <!-- Optional JS -->
    <script src="{{ asset('vendor/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('vendor/chart.js/dist/Chart.extension.js') }}"></script>
    <!-- Argon JS -->
    <script src="{{ asset('js/argon.min.js') }}"></script>

</body>

</html>