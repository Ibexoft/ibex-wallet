@extends('layouts.app')
@include('layouts.sidebar')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">Accounts Information</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <ul class="list-group">
                    @foreach ($accounts as $account)
                        <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-3 text-sm">{{ $account->name }}</h6>
                                <span class="mb-2 text-xs">Account Type: 
                                    <span class="text-dark font-weight-bold ms-sm-2">{{ $account->type }}</span>
                                </span>
                                <span class="mb-2 text-xs">Balance: 
                                    <span class="text-dark ms-sm-2 font-weight-bold">{{ $account->currency }} {{ number_format($account->balance, 2) }}</span>
                                </span>
                                <span class="text-xs">Completion: 
                                    <span class="text-dark ms-sm-2 font-weight-bold">{{ $account->completion }}%</span>
                                </span>
                            </div>
                            <div class="ms-auto text-end">
                                <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="far fa-trash-alt me-2"></i>Delete</a>
                                <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
