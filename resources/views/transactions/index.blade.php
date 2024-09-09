@extends('layouts.app')

@section('sidebar')
    @php
        use App\Enums\TransactionType as TransactionType;
    @endphp
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
        @include('transactions.list', ['transactions' => $transactions])
    </div>
    @include('transactions.add-edit-modal')
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            transactionInitialConfiguration();
            window.transactionRoutes = {
                store: "{{ route('transactions.store') }}",
                update: "{{ route('transactions.update', ['transaction' => '__TRANSACTION_ID__']) }}",
                destroy: "{{ route('transactions.destroy', ['transaction' => '__TRANSACTION_ID__']) }}",
                show: "{{ route('transactions.show', ['transaction' => '__TRANSACTION_ID__']) }}"
            };
        });
    </script>
@endsection
