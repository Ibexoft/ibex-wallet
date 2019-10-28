@extends('layouts.app')

@section('content')

<section class="row text-center placeholders">
    <div class="col-6 col-sm-4 placeholder">
        <div class="text-muted">Net Worth</div>
        <h4 class="text-success">{{ $total_balance }}</h4>
    </div>
    <div class="col-6 col-sm-4 placeholder">
        <div class="text-muted">Available Balance</div>
        <h4 class="text-success">{{ $available_balance }}</h4>
    </div>
    <div class="col-6 col-sm-4 placeholder">
        <span class="text-muted">Income this month</span>
        <h4 class="text-success">{{ $income_this_month }}</h4>
    </div>
    <div class="col-6 col-sm-4 placeholder">
        <span class="text-muted">Expense this month</span>
        <h4 class="text-danger">{{ $expense_this_month }}</h4>
    </div>
    <div class="col-6 col-sm-4 placeholder">
        <span class="text-muted">You Owe</span>
        <h4 class="text-success">{{ $owed }}</h4>
    </div>
    <div class="col-6 col-sm-4 placeholder">
        <span class="text-muted">Others Owe You</span>
        <h4 class="text-success">{{ $other_owed }}</h4>
    </div>
</section>

<div class="row">
    <div class="col-8"><h3>Transactions</h3></div>
    <div class="col-4"><a class="btn btn-primary pull-right" href="/transactions/create"><small>Add</small></a></div>
</div>

<table class="table table-responsive table-striped table-hover">
    <tr>
        <th></th>
        <th>Description</th>
        <th>Amount</th>
        <th>Type</th>
        <th>From Account</th>
        <th>To Account</th>
        <th>Date</th>
    </tr>
    @foreach ($transactions as $transaction)
        <tr>
            <td><input type="checkbox"></td>
            <td>
                <a href="/transactions/{{$transaction->id}}">{{ $transaction->description }}</a>
            </td> 
            <td>{{ $transaction->from_account ? $transaction->from_account->currency : ($transaction->to_account ? $transaction->to_account->currency : 'PKR') }} {{ $transaction->amount }}</td>
            <td>{{ $transaction->type }}</td>
            <td>{{ $transaction->from_account ? $transaction->from_account->title : "" }}</td>
            <td>{{ $transaction->to_account ? $transaction->to_account->title : "" }}</td>
            <td>{{ $transaction->created_at }}</td> 
        </tr>
    @endforeach
</table>

@endsection