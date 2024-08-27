<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            <!-- Navbar -->
            <nav
                class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow my-3 py-2 start-0 end-0 mx-4">
                <div class="container-fluid pe-0">
                    <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="../pages/dashboard.html">     
                    {{{ config('app.name', 'Ibex Wallet') }}}
                    </a>
                    <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon mt-2">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navigation">
                        <ul class="navbar-nav mx-auto ms-xl-auto ">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center me-2 active" aria-current="page"
                                    href="{{route('dashboard')}}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-2" href="{{route('transactions.index')}}">
                                    Transactions
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-2" href="{{route('accounts.index')}}">
                                   Accounts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-2" href="{{route('categories.index')}}">
                                    Categories
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav d-lg-block d-none">
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/product/soft-ui-dashboard"
                                    class="btn btn-sm btn-round mb-0 me-1 bg-gradient-dark">Free download</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
    </div>
</div>