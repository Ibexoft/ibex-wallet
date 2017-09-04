@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Transactions | <a href="/transactions/create"><small>Add</small></a></div>

                <div class="panel-body">
                    <ul>
                        @foreach ($transactions as $transaction)
                            <li> 
                                <a href="/transactions/{{$transaction->id}}"> 
                                    {{ $transaction->description }} | {{ $transaction->amount }} | {{ $transaction->type }} |
                                    {{ $transaction->from_account ? $transaction->from_account->name : "" }} | 
                                    {{ $transaction->to_account ? $transaction->to_account->name : "" }} | 
                                    {{ $transaction->created_at }} 
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>  
        </div>
    </div>
</div>
@endsection