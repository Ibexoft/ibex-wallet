@php
    use App\Enums\TransactionType as TransactionType;
@endphp
<div class="card transaction-card mb-4">
    <div class="card-header pb-0 px-3">
        <div class="row">
            <div class="col-12 col-md-6 text-center text-md-start mb-3 mb-md-0">
                <h6 class="mb-0">Your Transactions</h6>
            </div>
            @if (
                !request()->routeIs('dashboard')
            )
                <div class="col-12 col-md-6 d-flex justify-content-end align-items-center">
                    <div class="w-100 text-end">
                        <button type="button" class="btn bg-gradient-primary btn-block mb-3 w-100 w-md-50"
                            data-bs-toggle="modal" data-bs-target="#transactionModal" onclick="openModalForAdd()">
                            + New Transaction
                        </button>
                    </div>
                </div>
            @endif
            
        </div>
    </div>
    <div class="card-body pt-4 px-3 d-flex flex-column">
        @if ($transactions->isEmpty())
            <div class="d-flex flex-column align-items-center justify-content-center text-center py-5">
                <i class="fas fa-wallet mb-3 fs-1"></i>
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
                            data-id="{{ $transaction->id }}">
                            <div class="d-flex w-100" onclick="openModalForEdit(this)">
                                <div class="d-flex align-items-center justify-content-center">
                                    <button
                                        class="btn btn-icon-only btn-rounded btn-outline-{{ $transaction->type == TransactionType::Transfer ? 'info' : ($transaction->type == TransactionType::Expense ? 'danger' : 'success') }} mb-0 me-3 btn-sm d-flex align-items-center justify-content-center">
                                        <i
                                            class="fas fa-{{ $transaction->type == TransactionType::Transfer ? 'exchange-alt' : ($transaction->type == TransactionType::Expense ? 'arrow-down' : 'arrow-up') }}"></i>
                                    </button>
                                </div>
                                <div class="row w-100 d-flex align-items-center">
                                    <div class="col-6 h-100">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">
                                                    {{ $transaction->type == TransactionType::Transfer ? 'Transfer' : ($transaction->category ? $transaction->category->name : 'N/A') }}
                                                </h6>
                                                <span
                                                    class="text-xs d-none d-sm-block text-truncate transaction-detail">{{ $transaction->details }}</span>

                                                <span class="text-xs d-block d-sm-none">
                                                    @if ($transaction->type == TransactionType::Transfer)
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
                                                        @if ($transaction->type == TransactionType::Transfer)
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
                                                    class="d-flex align-items-center justify-content-center text-start text-{{ $transaction->type == TransactionType::Expense ? 'danger' : ($transaction->type == TransactionType::Transfer ? 'info' : 'success') }} text-gradient text-sm font-weight-bold">
                                                    {{ $transaction->type == TransactionType::Transfer ? '' : ($transaction->type == TransactionType::Expense ? '-' : '+') }}${{ number_format($transaction->amount, 2) }}
                                                </div>
                                                <div class="d-none d-sm-block d-md-none">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <span class="text-xs">
                                                            @if ($transaction->type == TransactionType::Transfer)
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
                                        <a class="dropdown-item py-1" href="#"
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

                        @if ($paginatedTransactions->lastPage() > 1)
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
                        @endif

                        @if ($paginatedTransactions->hasMorePages())
                            <li class="page-item">
                                <a class="page-link text-primary" href="{{ $paginatedTransactions->nextPageUrl() }}"
                                    aria-label="Next">
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

