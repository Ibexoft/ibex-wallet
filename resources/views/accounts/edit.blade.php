@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-6">
        <div class="card shadow">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">{{ title_case($account->title) }}</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('/accounts/' . $account->id) }}">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" value="{{ $account->id }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-alternative" id="title" name="title" placeholder="Account Title" value="{{ title_case($account->title) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control form-control-alternative" id="type" name="type">
                                    <option>Choose...</option>
                                    <option value="cash" {{ $account->type=='cash'?'selected':'' }}>Cash</option>
                                    <option value="bank" {{ $account->type=='bank'?'selected':'' }}>Bank</option>
                                    <option value="credit card" {{ $account->type=='credit card'?'selected':'' }}>Credit Card</option>
                                    <option value="mobile" {{ $account->type=='mobile'?'selected':'' }}>Mobile</option>
                                    <option value="other" {{ $account->type=='other'?'selected':'' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control form-control-alternative" id="currency" name="currency">
                                    <option>Choose...</option>
                                    <option value="PKR" {{ $account->currency=='PKR'?'selected':'' }}>PKR</option>
                                    <option value="SAR" {{ $account->currency=='SAR'?'selected':'' }}>SAR</option>
                                    <option value="AED" {{ $account->currency=='AED'?'selected':'' }}>AED</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg active">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
