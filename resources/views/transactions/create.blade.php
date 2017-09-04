@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Transactions</div>

                <div class="panel-body">
                    @include('layouts.errors')

                    <form method="POST" action="/transactions">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="amoount">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" placeholder="PKR 100" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="description" name="description" aria-describedby="nameHelp" placeholder="Enter description" required>
                            <small id="nameHelp" class="form-text text-muted">Transaction Description</small>
                        </div>
                        <div class="form-group">
                            <label for="type">Transaction Type</label>
                            <input type="text" class="form-control" id="type" name="type" placeholder="Transaction Type" required>
                        </div>
                        <div class="form-group">
                            <label for="from_account">From Account</label>
                            <input type="text" class="form-control" id="from_account" name="from_account" placeholder="From Account">
                        </div>
                        <div class="form-group">
                            <label for="to_account">To Account</label>
                            <input type="text" class="form-control" id="to_account" name="to_account" placeholder="To Account">
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text" class="form-control" id="tags" name="tags" placeholder="Tags">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection