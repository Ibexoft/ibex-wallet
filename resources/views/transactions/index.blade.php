@extends('layouts.app')

@section('sidebar')
    <div class="col-lg-3 mb-4 mb-lg-0">
        <div class="card">
            <form id="transaction-filter-form" action="{{ route('transactions.filter') }}" method="POST">
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

                        @csrf

                        <!-- Categories Filter -->
                        <div class="mb-3">
                            <span class="p-0 text-xs d-flex justify-content-between w-100 align-items-center"
                                data-bs-toggle="collapse" data-bs-target="#categoriesCollapse" aria-expanded="false"
                                aria-controls="categoriesCollapse">
                                <h6 class="mb-0 text-sm">Categories</h6>
                                <i class="fas fa-angle-right" id="categoriesIcon"></i>
                            </span>
                            <div id="categoriesCollapse" class="collapse pt-2">
                                <ul style="list-style: none; padding: 0;">
                                    @foreach ($categories as $category)
                                        @if (!$category->parent_category_id)
                                            <li>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input category-checkbox"
                                                        id="category{{ $category->id }}" name="categories[]"
                                                        value="{{ $category->id }}"
                                                        {{ isset($filters['categories']) && in_array($category->id, $filters['categories']) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="category{{ $category->id }}">
                                                        <i class="fa fa-angle-right toggle-icon"
                                                            onclick="toggleSubcategories('subcategory-category{{ $category->id }}', this, event)"></i>
                                                        {{ $category->name }}
                                                    </label>
                                                </div>
                                                <ul id="subcategory-category{{ $category->id }}" class="collapse pt-2"
                                                    style="list-style: none; padding-left: 20px;">
                                                    @if (count($category->subcategories))
                                                        @include('categories.subCategoryCheckbox', [
                                                            'subcategories' => $category->subcategories,
                                                            'indent' => 1,
                                                        ])
                                                    @endif
                                                </ul>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Dynamic Accounts Filter -->
                        <div class="mb-3">
                            <span class="p-0 text-xs d-flex justify-content-between w-100 align-items-center"
                                data-bs-toggle="collapse" data-bs-target="#accountCollapse" aria-expanded="false"
                                aria-controls="accountCollapse">
                                <h6 class="mb-0 text-sm">Accounts</h6>
                                <i class="fas fa-angle-right" id="accountIcon"></i>
                            </span>
                            <div id="accountCollapse" class="collapse pt-2">
                                @foreach ($accounts as $account)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="account{{ $account->id }}"
                                            name="accounts[]" value="{{ $account->id }}"
                                            {{ isset($filters['accounts']) && in_array($account->id, $filters['accounts']) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="account{{ $account->id }}">{{ $account->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Transaction Type Filter -->
                        <div class="mb-3">
                            <span class="p-0 text-xs d-flex justify-content-between w-100 align-items-center"
                                data-bs-toggle="collapse" data-bs-target="#transactionTypeCollapse" aria-expanded="false"
                                aria-controls="transactionTypeCollapse">
                                <h6 class="mb-0 text-sm">Transaction Type</h6>
                                <i class="fas fa-angle-right" id="transactionTypeIcon"></i>
                            </span>
                            <div id="transactionTypeCollapse" class="collapse pt-2">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="transactionType2"
                                        name="transaction_types[]" value="1"
                                        {{ isset($filters['transaction_types']) && in_array('1', $filters['transaction_types']) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="transactionType2">Expense</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="transactionType1"
                                        name="transaction_types[]" value="2"
                                        {{ isset($filters['transaction_types']) && in_array('2', $filters['transaction_types']) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="transactionType1">Income</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="transactionType3"
                                        name="transaction_types[]" value="3"
                                        {{ isset($filters['transaction_types']) && in_array('3', $filters['transaction_types']) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="transactionType3">Transfer</label>
                                </div>
                            </div>
                        </div>

                        <!-- Amount Range Filter -->
                        <div class="mb-3">
                            <span class="p-0 text-xs d-flex justify-content-between w-100 align-items-center"
                                data-bs-toggle="collapse" data-bs-target="#amountCollapse" aria-expanded="false"
                                aria-controls="amountCollapse">
                                <h6 class="mb-0 text-sm">Amount Range</h6>
                                <i class="fas fa-angle-right" id="amountIcon"></i>
                            </span>
                            <div id="amountCollapse" class="collapse pt-2">
                                <div class="row">
                                    <div class="col">
                                        <label for="min_amount" class="form-label">Min:</label>
                                        <input type="number" id="min_amount" name="min_amount" class="form-control"
                                            value="{{ isset($filters['min_amount']) ? $filters['min_amount'] : '' }}">
                                    </div>
                                    <div class="col">
                                        <label for="max_amount" class="form-label">Max:</label>
                                        <input type="number" id="max_amount" name="max_amount" class="form-control"
                                            value="{{ isset($filters['max_amount']) ? $filters['max_amount'] : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Date Range Filter -->
                        <div class="mb-3">
                            <span class="p-0 text-xs d-flex justify-content-between w-100 align-items-center"
                                data-bs-toggle="collapse" data-bs-target="#dateCollapse" aria-expanded="false"
                                aria-controls="dateCollapse">
                                <h6 class="mb-0 text-sm">Date Range</h6>
                                <i class="fas fa-angle-right" id="dateIcon"></i>
                            </span>
                            <div id="dateCollapse" class="collapse pt-2">
                                <div class="row">
                                    <div class="col">
                                        <label for="start_date" class="form-label">Start Date:</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control"
                                            value="{{ isset($filters['start_date']) ? $filters['start_date'] : '' }}">
                                    </div>
                                    <div class="col">
                                        <label for="end_date" class="form-label">End Date:</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control"
                                            value="{{ isset($filters['end_date']) ? $filters['end_date'] : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn bg-gradient-primary w-100 my-2">Apply Filters</button>
                        <a href="{{ route('transactions.index') }}" class="btn bg-gradient-secondary w-100">Clear
                            All Filters</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('content')
    <div class="col">
        <div class="card transaction-card mb-4">
            <div class="card-header pb-0 px-3">
                <div class="row">
                    <div class="col-12 col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <h6 class="mb-0">Your Transactions</h6>
                    </div>
                    <div class="col-12 col-md-6 d-flex justify-content-end align-items-center">
                        <div class="w-100 text-end">
                            <button type="button" class="btn bg-gradient-primary btn-block mb-3 w-100 w-md-50"
                                data-bs-toggle="modal" data-bs-target="#transactionModal" onclick="openModalForAdd()">
                                + New Transaction
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-4 px-3 d-flex flex-column">
                @if ($transactions->isEmpty())
                    <div class="d-flex flex-column align-items-center justify-content-center text-center py-5">
                        <i class="fas fa-wallet mb-3" style="font-size: 4rem;"></i>
                        <h6 class="mb-2">No Transactions Found</h6>
                        <p class="text-muted mb-0">You have no transactions to display at the moment. Start adding
                            transactions to see them here.</p>
                    </div>
                @else
                    @foreach ($transactions as $date => $transactionsOnDate)
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder my-1">{{ $date }}</h6>
                        <ul class="list-group">
                            @foreach ($transactionsOnDate as $transaction)
                                <li class="list-group-item transaction-item border-0 d-flex px-2 border-radius-lg"
                                    data-id="{{ $transaction->id }}" data-type="{{ $transaction->type }}"
                                    data-src-account-id="{{ $transaction->src_account_id }}"
                                    data-dest-account-id="{{ $transaction->dest_account_id }}"
                                    data-amount="{{ $transaction->amount }}"
                                    data-category-id="{{ $transaction->category_id }}"
                                    data-wallet-id="{{ $transaction->wallet_id }}"
                                    data-details="{{ $transaction->details }}"
                                    data-transaction-date="{{ $transaction->transaction_date }}">
                                    <div class="d-flex w-100" onclick="openModalForEdit(this)">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <button
                                                class="btn btn-icon-only btn-rounded btn-outline-{{ $transaction->type == 3 ? 'info' : ($transaction->type == 1 ? 'danger' : 'success') }} mb-0 me-3 btn-sm d-flex align-items-center justify-content-center">
                                                <i
                                                    class="fas fa-{{ $transaction->type == 3 ? 'exchange-alt' : ($transaction->type == 1 ? 'arrow-down' : 'arrow-up') }}"></i>
                                            </button>
                                        </div>
                                        <div class="row w-100 d-flex align-items-center">
                                            <div class="col-6 h-100">
                                                <div class="d-flex align-items-center">

                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark text-sm">
                                                            {{ $transaction->type == 3 ? 'Transfer' : ($transaction->category ? $transaction->category->name : 'N/A') }}
                                                        </h6>
                                                        <span class="text-xs d-none d-sm-block text-truncate"
                                                            style="max-width: 250px;">{{ $transaction->details }}</span>

                                                        <span class="text-xs d-block d-sm-none">
                                                            @if ($transaction->type == 3)
                                                                {{ $transaction->src_account->name }}
                                                                <i class="fas fa-long-arrow-alt-right mx-2"></i>
                                                                {{ $transaction->dest_account->name }}
                                                            @else
                                                                {{ $transaction->src_account->name }}
                                                            @endif
                                                        </span>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 h-100">
                                                <div class="row h-100 d-flex align-items-center">
                                                    <div class="d-none d-md-block col-0 col-md-7">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <span class="text-sm">
                                                                @if ($transaction->type == 3)
                                                                    {{ $transaction->src_account->name }}
                                                                    <i class="fas fa-long-arrow-alt-right mx-2"></i>
                                                                    {{ $transaction->dest_account->name }}
                                                                @else
                                                                    {{ $transaction->src_account->name }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-5">
                                                        <div
                                                            class="d-flex align-items-center justify-content-center text-start text-{{ $transaction->type == 1 ? 'danger' : ($transaction->type == 3 ? 'info' : 'success') }} text-gradient text-sm font-weight-bold">
                                                            {{ $transaction->type == 3 ? '' : ($transaction->type == 1 ? '-' : '+') }}${{ number_format($transaction->amount, 2) }}
                                                        </div>
                                                        <div class="d-none d-sm-block d-md-none">
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <span class="text-xs">
                                                                    @if ($transaction->type == 3)
                                                                        {{ $transaction->src_account->name }}
                                                                        <i class="fas fa-long-arrow-alt-right mx-2"></i>
                                                                        {{ $transaction->dest_account->name }}
                                                                    @else
                                                                        {{ $transaction->src_account->name }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a class="icon text-primary pb-4" href="#" data-bs-toggle="dropdown">
                                            <i class="fa fa-ellipsis-h py-1"></i>
                                        </a>
                                        <ul class="dropdown-menu shadow-md">
                                            <li>
                                                <a class="dropdown-item py-1" href="#" style="font-size: 12px;"
                                                    onclick="deleteTransaction(`{{ route('transactions.destroy', ['transaction' => $transaction->id]) }}`);">
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                    <div class="d-flex justify-content-center mt-4 flex-grow-1 align-items-end">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination pagination-lg justify-content-center align-items-center">
                                @if (!$paginatedTransactions->onFirstPage())
                                    <li class="page-item">
                                        <a class="page-link text-primary"
                                            href="{{ $paginatedTransactions->previousPageUrl() }}" aria-label="Previous">
                                            &laquo;
                                        </a>
                                    </li>
                                @endif

                                @foreach ($paginatedTransactions->links()->elements as $element)
                                    @if (is_string($element))
                                        <li class="page-item disabled"><span class="page-link">{{ $element }}</span>
                                        </li>
                                    @endif

                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $paginatedTransactions->currentPage())
                                                <li class="page-item active mx-1"><span
                                                        class="page-link bg-gradient-primary text-white border-0">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item mx-1"><a class="page-link text-primary border"
                                                        href="{{ $url }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                                @if ($paginatedTransactions->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link text-primary"
                                            href="{{ $paginatedTransactions->nextPageUrl() }}" aria-label="Next">
                                            &raquo;
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Combined Modal for Add/Edit -->
    <div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="transactionModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header px-5">
                    <h6 class="modal-title" id="transactionModalTitle">New Transaction</h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <form id="transactionForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="transaction_id" name="transaction_id">
                        <!-- Hidden field for transaction ID -->
                        <div class="form-group row">
                            <div class="btn-group btn-group-toggle mx-auto" data-toggle="buttons">
                                <label class="btn btn-outline-primary active" id="expense-btn">
                                    <input type="radio" class="d-none" name="type" value="1" checked
                                        onclick="changeTransactionType('expense')">
                                    Expense
                                </label>
                                <label class="btn btn-outline-primary" id="income-btn">
                                    <input type="radio" class="d-none" name="type" value="2"
                                        onclick="changeTransactionType('income')">
                                    Income
                                </label>
                                <label class="btn btn-outline-primary" id="transfer-btn">
                                    <input type="radio" class="d-none" name="type" value="3"
                                        onclick="changeTransactionType('transfer')">
                                    Transfer
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="src_account_id" id="account-label">Account <span
                                        class="text-danger">*</span></label>
                                <select name="src_account_id" id="src_account_id" class="form-control" required
                                    autocomplete="src_account_id">
                                    <option selected disabled value="">Select Account</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 form-group" id="collapseToAccount" style="display: none;">
                                <label for="dest_account_id">To Account <span class="text-danger">*</span></label>
                                <select name="dest_account_id" id="dest_account_id" class="form-control"
                                    autocomplete="dest_account_id">
                                    <option selected disabled>Select Account</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 form-group" id="amount-field">
                                <label for="amount">Amount <span class="text-danger">*</span></label>
                                <input id="amount" type="number" min="0" step="0.01" class="form-control"
                                    placeholder="Enter Amount" name="amount" required autocomplete="amount">
                            </div>
                            <div class="col-6 form-group" id="category-field">
                                <label for="category_id">Category <span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id" class="form-control"
                                    autocomplete="category_id">
                                    <option selected disabled value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @if (count($category->subcategories))
                                            @include ('categories.subCategoryOption', [
                                                'subcategories' => $category->subcategories,
                                                'indent' => 1,
                                            ])
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 form-group" id="wallet-field">
                                <label for="wallet_id">Wallet</label>
                                <select name="wallet_id" id="wallet_id" class="form-control" required
                                    autocomplete="wallet_id">
                                    @foreach ($wallets as $wallet)
                                        <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="details">Details</label>
                            <input id="details" type="text" class="form-control" name="details" maxlength="200"
                                autocomplete="details" placeholder="Enter Details" title="Details about the transaction">
                        </div>
                        <div class="form-group">
                            <label for="transaction_date">Date <span class="text-danger">*</span></label>
                            <input id="transaction_date" type="date" class="form-control" name="transaction_date"
                                value="{{ date('Y-m-d') }}" required autocomplete="transaction_date">
                        </div>
                        <div class="text-center">
                            <button type="submit" id="transactionModalSubmitBtn"
                                class="btn bg-gradient-primary w-100 w-md-50">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            transactionInitialConfiguration();
            window.transactionRoutes = {
                store: "{{ route('transactions.store') }}",
                update: "{{ route('transactions.update', ['transaction' => '__TRANSACTION_ID__']) }}",
                destroy: "{{ route('transactions.destroy', ['transaction' => '__TRANSACTION_ID__']) }}"
            };
        });
    </script>
@endsection
