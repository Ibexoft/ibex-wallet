@extends('layouts.master')

@section('content')

    <div class="container">
        <h1>Add Account</h1>

        @if(count($errors))
            <div class="alert alert-danger">
                <ul>            
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="/accounts">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Account Name</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" placeholder="Enter account name" required>
                <small id="nameHelp" class="form-text text-muted">Name of your account</small>
            </div>
            <div class="form-group">
                <label for="type">Account Type</label>
                <input type="text" class="form-control" id="type" name="type" placeholder="Account Type" required>
            </div>
            <div class="form-group">
                <label for="currency">Currency</label>
                <input type="text" class="form-control" id="currency" name="currency" placeholder="Account Currency" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Add Account</button>
            </div>
        </form>
    </div>

@endsection