@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Transaction details</div>

                <div class="panel-body">
                    <p><strong>Amount</strong>: {{ $transaction->amount }}</p>
                    <p><strong>Description</strong>: {{ $transaction->description }}</p>
                    <p><strong>Type</strong>: {{ $transaction->type }}</p>
                    <p><strong>From Account</strong>: {{ $transaction->from_account ? $transaction->from_account->name : "" }}</p>
                    <p><strong>To Account</strong>: {{ $transaction->to_account ? $transaction->to_account->name : "" }}</p>
                    
                    <p><strong>Tags</strong>:
                    @foreach($transaction->tags as $tag)
                        {{ $tag->name }}
                    @endforeach
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection