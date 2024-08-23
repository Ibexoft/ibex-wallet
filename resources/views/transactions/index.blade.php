@extends('layouts.app')
@section('content')
    @php
        $groupedTransactions = $transactions->groupBy(function ($transaction) {
            return \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y');
        });
    @endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header pb-0 px-3">
                        <h5 class="mb-0">Filter</h5>
                    </div>
                    <div class="card-body">
                        <form id="transaction-filter-form" action="/filter-transactions" method="POST">

                            <!-- Dynamic Categories with Tree Structure -->
                            <div class="mb-3">
                                <h6>Categories</h6>
                                <ul style="list-style: none; padding: 0;">
                                    @foreach ($categories as $category)
                                        @if (!$category->parent_category_id)  <!-- Only display categories with no parent -->
                                            <li>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input category-checkbox" id="category{{ $category->id }}" name="categories[]" value="{{ $category->id }}">
                                                    <label class="form-check-label" for="category{{ $category->id }}">
                                                        <i class="fa fa-caret-right toggle-icon" onclick="toggleSubcategories('subcategory-category{{ $category->id }}', this)"></i>
                                                        {{ $category->name }}
                                                    </label>
                                                </div>
                                                <ul id="subcategory-category{{ $category->id }}" class="collapse" style="list-style: none; padding-left: 20px;">
                                                    @if (count($category->subcategories))
                                                        @include('categories.subCategoryCheckbox', ['subcategories' => $category->subcategories, 'indent' => 1])
                                                    @endif
                                                </ul>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Dynamic Accounts -->
                            <div class="mb-3">
                                <h6>Accounts</h6>
                                @foreach ($accounts as $account)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="account{{ $account->id }}"
                                            name="accounts[]" value="{{ $account->id }}">
                                        <label class="form-check-label"
                                            for="account{{ $account->id }}">{{ $account->name }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Transaction Type -->
                            <div class="mb-3">
                                <h6>Transaction Type</h6>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="transactionType1"
                                        name="transaction_types[]" value="Income">
                                    <label class="form-check-label" for="transactionType1">Income</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="transactionType2"
                                        name="transaction_types[]" value="Expense">
                                    <label class="form-check-label" for="transactionType2">Expense</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="transactionType3"
                                        name="transaction_types[]" value="Transfer">
                                    <label class="form-check-label" for="transactionType3">Transfer</label>
                                </div>
                            </div>

                            <!-- Amount Filter -->
                            <div class="mb-3">
                                <h6>Amount Range</h6>
                                <div class="row">
                                    <div class="col">
                                        <label for="min_amount" class="form-label">Minimum Amount:</label>
                                        <input type="number" id="min_amount" name="min_amount" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="max_amount" class="form-label">Maximum Amount:</label>
                                        <input type="number" id="max_amount" name="max_amount" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!-- Date Range -->
                            <div class="mb-3">
                                <h6>Date Range</h6>
                                <div class="row">
                                    <div class="col">
                                        <label for="start_date" class="form-label">Start Date:</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="end_date" class="form-label">End Date:</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                        </form>
                    </div>
                </div>

            </div>
            <div class="col">
                <div class="card h-100 mb-4">
                    <div class="card-header pb-0 px-3">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="mb-0">Your Transactions</h6>
                            </div>
                            <div class="col-6 d-flex justify-content-end align-items-center">
                                <!-- Open modal for new transaction -->
                                <button type="button" class="btn bg-gradient-primary btn-block mb-3"
                                    data-bs-toggle="modal" data-bs-target="#transactionModal"
                                    onclick="openModalForAdd()">
                                    + New Transaction
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-4 px-5">
                        @foreach ($groupedTransactions as $date => $transactionsOnDate)
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">{{ $date }}</h6>
                            <ul class="list-group">
                                @foreach ($transactionsOnDate as $transaction)
                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg"
                                        data-id="{{ $transaction->id }}" data-type="{{ $transaction->type }}"
                                        data-src-account-id="{{ $transaction->src_account_id }}"
                                        data-dest-account-id="{{ $transaction->dest_account_id }}"
                                        data-amount="{{ $transaction->amount }}"
                                        data-category-id="{{ $transaction->category_id }}"
                                        data-wallet-id="{{ $transaction->wallet_id }}"
                                        data-details="{{ $transaction->details }}"
                                        data-transaction-date="{{ $transaction->transaction_date }}"
                                        onclick="openModalForEdit(this)">

                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <button
                                                    class="btn btn-icon-only btn-rounded btn-outline-{{ $transaction->type == 3 ? 'info' : ($transaction->type == 1 ? 'danger' : 'success') }} mb-0 me-3 btn-sm d-flex align-items-center justify-content-center">
                                                    <i
                                                        class="fas fa-{{ $transaction->type == 3 ? 'exchange-alt' : ($transaction->type == 1 ? 'arrow-down' : 'arrow-up') }}"></i>
                                                </button>
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-1 text-dark text-sm">
                                                        {{ $transaction->type == 3 ? 'Transfer' : ($transaction->category ? $transaction->category->name : 'N/A') }}
                                                    </h6>
                                                    <span class="text-xs">{{ $transaction->details }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        @if ($transaction->type == 3)
                                                            {{ $transaction->src_account->name }}
                                                            <i class="fas fa-exchange-alt mx-3"></i>
                                                            {{ $transaction->dest_account->name }}
                                                        @else
                                                            {{ $transaction->src_account->name }}
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="row">
                                                        <div
                                                            class="col d-flex align-items-center text-start text-{{ $transaction->type == 1 ? 'danger' : ($transaction->type == 3 ? 'info' : 'success') }} text-gradient text-sm font-weight-bold">
                                                            {{ $transaction->type == 3 ? '' : ($transaction->type == 1 ? '- ' : '+ ') }}${{ number_format($transaction->amount, 2) }}
                                                        </div>
                                                        <div class="col-1">
                                                            <a class="icon text-primary" href="#"
                                                                data-bs-toggle="dropdown"
                                                                onclick="event.stopPropagation();">
                                                                <i class="fa fa-ellipsis-h py-1"></i>
                                                            </a>
                                                            <ul class="dropdown-menu shadow-md">
                                                                <li>
                                                                    <a class="dropdown-item py-1" href="#"
                                                                        style="font-size: 12px;"
                                                                        onclick="event.stopPropagation(); deleteTransaction(`{{ route('transactions.destroy', ['transaction' => $transaction->id]) }}`);">
                                                                        Delete
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Combined Modal for Add/Edit -->
    <div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="transactionModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                                    <input type="radio" class="d-none" name="type" value="1"
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
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 form-group" id="collapseToAccount" style="display: none;">
                                <label for="dest_account_id">To Account</label>
                                <select name="dest_account_id" id="dest_account_id" class="form-control"
                                    autocomplete="dest_account_id">
                                    <option></option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 form-group" id="amount-field">
                                <label for="amount">Amount <span class="text-danger">*</span></label>
                                <input id="amount" type="number" min="0" step="0.01" class="form-control"
                                    name="amount" required autocomplete="amount">
                            </div>
                            <div class="col-6 form-group" id="category-field">
                                <label for="category_id">Category <span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id" class="form-control"
                                    autocomplete="category_id">
                                    <option></option>
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
                            <label for="details">Description</label>
                            <input id="details" type="text" class="form-control" name="details"
                                autocomplete="details" placeholder="Enter Details e.g. Eggs, bread, oil etc."
                                title="Details about the transaction">
                        </div>
                        <div class="form-group">
                            <label for="transaction_date">Date <span class="text-danger">*</span></label>
                            <input id="transaction_date" type="date" class="form-control" name="transaction_date"
                                required autocomplete="transaction_date">
                        </div>
                        <div class="text-center">
                            <button type="submit" id="transactionModalSubmitBtn"
                                class="btn bg-gradient-primary w-75">Add</button>
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
            window.transactionRoutes = {
                store: "{{ route('transactions.store') }}",
                update: "{{ route('transactions.update', ['transaction' => '__TRANSACTION_ID__']) }}",
                destroy: "{{ route('transactions.destroy', ['transaction' => '__TRANSACTION_ID__']) }}"
            };
        });
    </script>
@endsection
