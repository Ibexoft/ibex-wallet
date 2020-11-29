@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Accounts
                    <a href="accounts/create" class="small float-right">Add Account</a>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Name</th>
                                {{-- <th>Type</th> --}}
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($accounts as $account)
                            <tr>
                                <td>{{ $account->id }}</td>
                                <td>
                                    <a href="{{ route('accounts.edit', ['account' => $account->id]) }}">
                                        {{ $account->name }}
                                    </a>
                                </td>
                                {{-- <td>{{ $account->type }}</td> --}}
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