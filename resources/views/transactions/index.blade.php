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

                <div class="card-body">
                    @foreach ($transactions as $transaction)
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('transactions.edit', ['transaction' => $transaction->id]) }}">
                                {{ $transaction->category->name }}{{ $transaction->details ? ': ' . $transaction->details : ''}}
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
