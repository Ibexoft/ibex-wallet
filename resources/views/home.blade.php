@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Transactions</div>

                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Account</th>
                                <th>Amount</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->transaction_date }}</td>
                                <td>{{ $transaction->category ? $transaction->category->name : '' }}</td>
                                <td>
                                    <a href="{{ route('transactions.edit', ['transaction' => $transaction->id]) }}">
                                        <small class="text-muted">{{ $transaction->details ? $transaction->details : '' }}</small>
                                    </a>
                                </td>
                                <td>{{ $transaction->type ==  \App\Enums\TransactionType::Expense->value ? 'Expense' : ($transaction->type == config('custom.transaction_types.income') ? 'Income' : 'Transfer') }}</td>
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
            @include('transactions.create-widget',['transaction' => null])
        </div>
    </div>

</div>

@endsection
