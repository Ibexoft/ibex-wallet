@extends('layouts.master')

@section('content')

    <h1>Account details</h1>
    <p><strong>Account name</strong>: {{ $account->name }}</p>
    <p><strong>Type</strong>: {{ $account->type }}</p>
    <p><strong>Currency</strong>: {{ $account->currency }}</p>

    <a href="/accounts"><< Go Back</a>
    
@endsection