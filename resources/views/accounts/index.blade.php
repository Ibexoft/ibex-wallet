@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Accounts</div>

                <div class="panel-body">
                    <div class="pull-right">
                        <a class="btn btn-primary" href="/accounts/create"><small>Add</small></a>
                    </div>
                    
                    <table class="table table-striped table-hover">
                        <tr>
                            <th></th>
                            <th>Account</th>
                            <th>Type</th>
                        </tr>
                        @foreach ($accounts as $account)
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>
                                    <a href="/accounts/{{$account->id}}">{{ $account->name }}</a>
                                </td> 
                                <td>{{ $account->type }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection