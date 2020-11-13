@extends('layouts.app')

@section('content')

<div class="container">

    {{-- <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">This month stats</div>

                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Expense</div>
                                <div class="card-body">2342</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Income</div>
                                <div class="card-body">123234</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="mt-4 row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Transactions</div>

                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Date</th>
                                <th>Details</th>
                                <th>Account</th>
                                <th>Amount</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->transaction_date }}</td>
                                <td>
                                    <a href="{{ route('transactions.edit', ['transaction' => $transaction->id]) }}">
                                        {{ $transaction->category->name }}<small class="text-muted">{{ $transaction->details ? ' - ' . $transaction->details : '' }}</small>
                                    </a>
                                </td>
                                <td>{{ $transaction->src_account->name }}</td>
                                <td>{{ $transaction->amount }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @include('transactions.create-widget')
        </div>
    </div>

</div>

@endsection