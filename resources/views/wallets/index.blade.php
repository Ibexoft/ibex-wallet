@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Wallets
                    <a href="wallets/create" class="small float-right">New Wallet</a>
                </div>

                <div class="card-body">
                    @foreach ($wallets as $wallet)
                    <div class="row">
                        <div class="col-md-6">
                            {{ $wallet->name }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection