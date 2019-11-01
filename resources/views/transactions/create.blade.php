
@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-xl">
        <div class="card shadow">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Add Transaction</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ url('/transactions') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-alternative" id="amount" name="amount" placeholder="100" value="{{ old('amount') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-alternative" id="description" name="description" placeholder="Description" value="{{ old('description') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control form-control-alternative" id="type" name="type">
                                    <option>Type</option>
                                    <option value="expense">Expense</option>
                                    <option value="return">Return</option>
                                    <option value="lend">Lend</option>
                                    <option value="settlement w">Settlement (Withdraw)</option>
                        
                                    <option value="income">Income</option>
                                    <option value="refund">Refund</option>
                                    <option value="borrow">Borrow</option>
                                    <option value="settlement d">Settlement (deposit)</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control form-control-alternative" id="from_account" name="from_account">
                                    <option>From Account</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}" {{ (old('from_account') == $account->title) ? 'selected' : '' }}>{{ $account->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control form-control-alternative" id="to_account" name="to_account">
                                    <option>To Account</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}" {{ (old('to_account') == $account->title) ? 'selected' : '' }}>{{ $account->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-alternative" id="for_whom" name="for_whom" placeholder="For whom" value="{{ old('for_whom') }}">
                            </div>
                        </div>
                    </div>

                      {{-- <div class="form-group">
        <label for="tags">Tags</label>
        <select multiple class="form-control" id="tags" name="tags[]">
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
            @endforeach
        </select>
    </div> --}}

                    <div class="row">
                        <div class="col-md-12 text-right">
                            <div class="form-group">
                                <span class="p-4"><a class="mr-15" href="{{ route('transactions.index') }}">Go Back</a></span>
                                <span class="p-4"><button type="submit" class="btn btn-primary btn-lg active">Add Transaction</button></span>
                            </div>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
