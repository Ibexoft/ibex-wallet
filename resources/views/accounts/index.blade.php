@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Accounts
                    <a href="accounts/create" class="small float-right">New Account</a>
                </div>

                <div class="card-body">
                    @foreach ($accounts as $account)
                    <div class="row">
                        <div class="col-md-6">
                            {{ $account->name }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection