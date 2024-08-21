@extends('layouts.app')


@section('content')
    @php
        $groupedTransactions = $transactions->groupBy(function ($transaction) {
            return \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y');
        });
    @endphp
    <div class="container-fluid">
        <div class="card h-100 mb-4">
            <div class="card-header pb-0 px-3">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-0">Your Transactions</h6>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                        <i class="far fa-calendar-alt me-2"></i>
                        {{-- Date filter can go here if needed --}}
                    </div>
                </div>
            </div>
            <div class="card-body pt-4 p-3">
                @foreach ($groupedTransactions as $date => $transactionsOnDate)
                    <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">{{ $date }}</h6>
                    <ul class="list-group">
                        @foreach ($transactionsOnDate as $transaction)
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <button
                                        class="btn btn-icon-only btn-rounded btn-outline-{{ $transaction->type == 1 ? 'danger' : 'success' }} mb-0 me-3 btn-sm d-flex align-items-center justify-content-center">
                                        <i class="fas fa-arrow-{{ $transaction->type == 1 ? 'down' : 'up' }}"></i>
                                    </button>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">
                                            {{ $transaction->category ? $transaction->category->name : 'N/A' }}</h6>
                                        <span class="text-xs">{{ $transaction->details }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center ">
                                    {{ $transaction->src_account->name }}
                                </div>
                                <div
                                    class="d-flex align-items-center text-{{ $transaction->type == 1 ? 'danger' : 'success' }} text-gradient text-sm font-weight-bold">
                                    {{ $transaction->type == 1 ? '- ' : '+ ' }}${{ number_format($transaction->amount, 2) }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
    </div>
@endsection
