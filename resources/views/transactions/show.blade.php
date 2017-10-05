@extends('layouts.app')

@section('content')

<p><strong>Amount</strong>: {{ $transaction->from_account->currency ?? $transaction->to_account->currency }} {{ $transaction->amount }}</p>
<p><strong>Description</strong>: {{ $transaction->description }}</p>
<p><strong>Type</strong>: {{ $transaction->type }}</p>
<p><strong>From Account</strong>: {{ $transaction->from_account ? $transaction->from_account->name : "" }}</p>
<p><strong>To Account</strong>: {{ $transaction->to_account ? $transaction->to_account->name : "" }}</p>

<p><strong>Tags</strong>:
@foreach($transaction->tags as $tag)
    {{ $tag->name }}
@endforeach
</p>

<p><strong>For whom</strong>: {{ $transaction->for_whom }}</p>
                
@endsection