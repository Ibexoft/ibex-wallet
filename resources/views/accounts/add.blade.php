@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-xl">
        <div class="card shadow">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Create Account</h3>
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
                <form method="POST" action="{{ url('/accounts') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-alternative" id="title" name="title" placeholder="Account Title" value="{{ old('title') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control form-control-alternative" id="type" name="type">
                                    <option></option>
                                    <option value="cash" {{ old('type')=='cash'?'selected':'' }}>Cash</option>
                                    <option value="bank" {{ old('type')=='bank'?'selected':'' }}>Bank</option>
                                    <option value="credit card" {{ old('type')=='credit card'?'selected':'' }}>Credit Card</option>
                                    <option value="mobile" {{ old('type')=='mobile'?'selected':'' }}>Mobile</option>
                                    <option value="other" {{ old('type')=='other'?'selected':'' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control form-control-alternative" id="currency" name="currency">
                                    <option></option>
                                    <option value="PKR" {{ old('currency')=='PKR'?'selected':'' }}>PKR</option>
                                    <option value="SAR" {{ old('currency')=='SAR'?'selected':'' }}>SAR</option>
                                    <option value="AED"{{ old('currency')=='AED'?'selected':'' }}>AED</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary active">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
