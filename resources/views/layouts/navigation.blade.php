<div class="container-fluid z-index-sticky top-0 position-sticky">

    <div class="row">
        <div class="col-12">
            <!-- Navbar -->
            <nav
                class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow my-3 py-2 start-0 end-0">
                <div class="container-fluid px-0">
                    <button class="navbar-toggler shadow-none border-0 outline-none px-0" type="button"
                        data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon mt-2">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </span>
                    </button>
                    <a class="navbar-brand d-inline w-lg-15 w-sm-30 w-40 mx-lg-2 mx-auto" href="{{ route('dashboard') }}"
                        id="header-logo">
                        <img src="{{ asset('assets/img/ibex_wallet_logo.png') }}" alt="Ibex Wallet Logo" class="w-100">
                    </a>
                    <div class="d-lg-none d-block">
                        @if (Auth::check())
                        <div class="dropdown">
                            <a class="avatar avatar-sm shadow-md cursor-pointer rounded-circle overflow-hidden mt-2"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets/img/user-placeholder.png') }}"
                                    alt="team4">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a href="{{ route('profile.show', ['profile' => Auth::user()->id]) }}"
                                        class="nav-link dropdown-item">
                                        Profile
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a class="nav-link dropdown-item"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                            Logout
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endif
                    </div>
                    <div class="collapse navbar-collapse" id="navigation">
                        <ul class="navbar-nav mx-auto ms-xl-auto ">
                            @if (Auth::user())
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center me-2 {{ Route::is('dashboard') ? 'text-primary' : '' }}"
                                        aria-current="page" href="{{ route('dashboard') }}">
                                        Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link me-2 {{ Route::is('transactions.index') ? 'text-primary' : '' }}"
                                        href="{{ route('transactions.index') }}">
                                        Transactions
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link me-2 {{ Route::is('accounts.index') ? 'text-primary' : '' }}"
                                        href="{{ route('accounts.index') }}">
                                        Accounts
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link me-2 {{ Route::is('categories.index') ? 'text-primary' : '' }}"
                                        href="{{ route('categories.index') }}">
                                        Categories
                                    </a>
                                </li>
                            @endif
                        </ul>
                        <ul class="navbar-nav d-lg-block d-none">
                            @if (Auth::check())
                                <div class="dropdown">
                                    <a class="avatar avatar-sm shadow-md cursor-pointer rounded-circle overflow-hidden mt-2"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets/img/user-placeholder.png') }}"
                                            alt="team4">
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end pb-0">
                                        <li>
                                            <a href="{{ route('profile.show', ['profile' => Auth::user()->id]) }}"
                                                class="nav-link dropdown-item">
                                                Profile
                                            </a>
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <a class="nav-link dropdown-item"
                                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                                    Logout
                                                </a>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </ul>
                        

                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
    </div>
</div>
