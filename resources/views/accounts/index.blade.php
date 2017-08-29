@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h1>Accounts</h1>
            </div>
            <div class="col-4">
                <span><a class="btn btn-primary" href="/accounts/create">Add Account</a></span>
            </div>
        </div>

        <div class="row">
            <ul>
                @foreach ($accounts as $account)
                    <li> 
                        <a href="accounts/{{$account->id}}"> 
                            {{ $account->name }} 
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection