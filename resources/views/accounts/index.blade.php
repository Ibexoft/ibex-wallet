@extends('layouts.app')

@section('sidebar')
    <div class="col-lg-3 mb-4 mb-lg-0">
        <div class="card">
            <form id="account-filter-form" action="{{ route('accounts.index') }}" method="GET">
                <div class="card-header pb-0 px-3">
                    <span class="text-dark px-2 d-flex justify-content-between w-100 align-items-center"
                        data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="true"
                        aria-controls="filterCollapse">
                        <h6 class="mb-0">Filter</h6>
                        <i class="fas fa-angle-down" id="filterIcon"></i>
                    </span>
                </div>
                <div class="card-body pb-0">
                    <div id="filterCollapse" class="pt-0 collapse show" data-bs-parent="#accordionExample">
                        <div class="mb-3">
                            <label for="accountSearch" class="form-label">Search Accounts</label>
                            <input type="text" class="form-control" id="accountSearch" name="search"
                                placeholder="Search by name" value="{{ request('search') }}">
                        </div>

                        <div class="mb-3">
                            <label for="sortOrder" class="form-label">Sort By</label>
                            <select class="form-select" id="sortOrder" name="sort">
                                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name (A-Z)
                                </option>
                                <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name (Z-A)
                                </option>
                                <option value="balance_asc" {{ request('sort') === 'balance_asc' ? 'selected' : '' }}>
                                    Balance (Low to High)</option>
                                <option value="balance_desc" {{ request('sort') === 'balance_desc' ? 'selected' : '' }}>
                                    Balance (High to Low)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn bg-gradient-primary w-100 my-2">Apply Filters</button>
                        <a href="{{ route('accounts.index') }}" class="btn bg-gradient-secondary w-100">Clear
                            All Filters</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('content')
    <div class="col mb-4">
        <div class="card">
            <div class="card-header pb-0 d-block d-sm-flex justify-content-between mt-0">
                <h6 class="mb-sm-2 mb-md-0 text-center text-sm-start">Accounts Information</h6>
                <button type="button" class="btn btn-block bg-gradient-primary mb-3 w-100 w-sm-auto" data-bs-toggle="modal"
                    data-bs-target="#modal-default">+ Add Account</button>
            </div>
            <div class="card-body pt-4 p-3">
                <ul class="list-group">
                    @if ($accounts->isEmpty())
                        <div class="d-flex flex-column align-items-center justify-content-center text-center py-5">
                            <i class="fas fa-vault mb-3 fs-1"></i>
                            <h6 class="mb-2">No Accounts Found</h6>
                            <p class="text-muted mb-0">You have no accounts to display at the moment.</p>
                        </div>
                    @endif
                    @foreach ($accounts as $account)
                        <li class="list-group-item border-0 px-4 mb-3 bg-gray-100 border-radius-lg account-item">
                            <!-- Dropdown Trigger -->
                            <div class="w-100 text-end">
                                <div class="d-inline ">
                                    <i class="icon fa fa-ellipsis-h text-sm text-primary cursor-pointer"
                                        id="dropdownMenuButton{{ $account->id }}" data-bs-toggle="dropdown"
                                        aria-expanded="false"></i>

                                    <!-- Dropdown Menu -->
                                    <ul class="dropdown-menu shadow-md"
                                        aria-labelledby="dropdownMenuButton{{ $account->id }}">
                                        <li>
                                            <a class="dropdown-item py-1" href="javascript:;"
                                                onclick="deleteAccount({{ $account->id }});">Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div onclick="fetchAccountData('{{ route('accounts.show', [$account->id]) }}')">
                                {{-- For Mobile Screen --}}
                                <div class="row pb-2 d-flex d-md-none align-items-center">
                                    <div class="col-2">
                                        <div
                                            class="icon icon-sm icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                            <i class="{{ config('custom.account_types')[$account->type]['icon'] }} text-lg opacity-10 mt-1"
                                                aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <div class="d-flex flex-column ps-2 ps-md-0">
                                            <h6 class="m-0 text-sm">{{ $account->name }}</h6>
                                            <p class="m-0 text-xs">
                                                {{ config('custom.account_types')[$account->type]['name'] }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="ms-auto text-end ">
                                            <h6 class="text-dark font-weight-bold m-0">
                                                {{ $account->currency }} {{ number_format($account->balance, 2) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>

                                {{-- For Tablets and Desktop --}}
                                <div class="row pb-2 d-none d-md-flex">
                                    <div class="col-1">
                                        <div
                                            class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                            <i class="{{ config('custom.account_types')[$account->type]['icon'] }} text-lg opacity-10 top-0 mt-3"
                                                aria-hidden="true"></i>
                                        </div>

                                    </div>
                                    <div class="col-11 d-flex align-items-center">
                                        <div class="d-flex flex-column">
                                            <h6 class="m-0">{{ $account->name }}</h6>
                                            <p class="m-0 text-xs">
                                                {{ config('custom.account_types')[$account->type]['name'] }}
                                            </p>
                                        </div>
                                        <div class="ms-auto text-end ">
                                            <h5 class="text-dark font-weight-bold m-0">
                                                {{ $account->currency }} {{ number_format($account->balance, 2) }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    @include('accounts.partials.add-account-modal')
    @include('accounts.partials.edit-account-modal')
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            window.accountRoutes = {
                store: "{{ route('accounts.store') }}",
                update: "{{ route('accounts.update', ['account' => '__ACCOUNT_ID__']) }}",
                destroy: "{{ route('accounts.destroy', ['account' => '__ACCOUNT_ID__']) }}"
            };
        });
    </script>
@endsection
