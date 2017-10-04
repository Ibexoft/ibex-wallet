@extends('layouts.app')

@section('content')

<div class="row-fluid">
    <div class="col-md-3">
        <h4>Net Worth</h4>
        <currency>Rs.10000</currency>
    </div>
    <div class="col-md-3">
        <h4>Income this month</h4>
        <currency>Rs.10000</currency>
    </div>
    <div class="col-md-3">
        <h4>Expense this month</h4>
        <currency>Rs.10000</currency>
    </div>
    <div class="col-md-3">
        <h4>Owed</h4>
        <currency>Rs.10000</currency>
    </div>
</div>

<div class="pull-right">
    <a class="btn btn-primary" href="/transactions/create"><small>Add</small></a>
</div>

<table class="table table-striped table-hover">
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
            <td>{{ $transaction->amount }}</td>
            <td>{{ $transaction->type }}</td>
            <td>{{ $transaction->from_account ? $transaction->from_account->name : "" }}</td>
            <td>{{ $transaction->to_account ? $transaction->to_account->name : "" }}</td>
            <td>{{ $transaction->created_at }}</td> 
        </tr>
    @endforeach
</table>

@endsection