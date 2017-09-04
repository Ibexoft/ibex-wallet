@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Account Details</div>

                <div class="panel-body">
                    <p><strong>Account name</strong>: {{ $account->name }}</p>
                    <p><strong>Type</strong>: {{ $account->type }}</p>
                    <p><strong>Currency</strong>: {{ $account->currency }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection