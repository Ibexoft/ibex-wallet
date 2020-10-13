@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Expense</div>
                            <div class="card-body">2342</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Income</div>
                            <div class="card-body">123234</div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            @include('transactions.create-widget')
        </div>
    </div>
</div>

@endsection