@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Transactions <small>({{ $transactions->count() }})</small>
                    <a href="transactions/create" class="small float-right">Add Expense/Income</a>
                </div>

                {{-- <div class="card-body">
                    @foreach ($transactions as $transaction)
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('transactions.edit', ['transaction' => $transaction->id]) }}">
                                {{ $transaction->category->name }}{{ $transaction->details ? ': ' . $transaction->details : ''}}
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div> --}}

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
    </div>
</div>
@endsection
