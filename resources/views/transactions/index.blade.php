@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Transactions</div>

                <div class="panel-body">
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
                </div>
            </div>  
        </div>
    </div>
</div>
@endsection