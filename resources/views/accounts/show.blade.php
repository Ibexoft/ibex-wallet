@extends('layouts.app')

@section('content')

<p><strong>Account name</strong>: {{ $account->name }}</p>
<p><strong>Type</strong>: {{ $account->type }}</p>
<p><strong>Currency</strong>: {{ $account->currency }}</p>
                
@endsection