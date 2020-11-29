@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Wallets
                    <a href="wallets/create" class="small float-right">Add Wallet</a>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Name</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($wallets as $wallet)
                            <tr>
                                <td>{{ $wallet->id }}</td>
                                <td>
                                    <a href="{{ route('wallets.edit', ['wallet' => $wallet->id]) }}">
                                        {{ $wallet->name }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection