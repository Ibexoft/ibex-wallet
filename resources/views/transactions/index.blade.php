@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Transactions
                    <a href="transactions/create" class="small float-right">New Transaction</a>
                </div>

                <div class="card-body">
                    @foreach ($transactions as $transaction)
                    <div class="row">
                        <div class="col-md-6">
                            {{ $transaction->amount }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection