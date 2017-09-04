@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Accounts | <a href="/accounts/create"><small>Add</small></a></div>

                <div class="panel-body">
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
        </div>
    </div>
</div>
@endsection