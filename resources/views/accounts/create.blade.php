@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $account ?? '' ? 'Update' : 'Add' }} Account</div>

                <div class="card-body">
                    <form method="POST" action="{{ $account ?? '' ? route('accounts.update', ['account' => $account->id]) : route('accounts.store') }}">
                        @if ($account ?? '') @method('PUT') @endif
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $account ?? '' ? $account->name : old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">Type</label>

                            <div class="col-md-6">
                                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required autocomplete="type">
                                    <option></option>
                                    <option value="1" {{ $account ?? '' ? $account->type == 1 ? 'selected' : '' : '' }}>Cash</option>
                                    <option value="2" {{ $account ?? '' ? $account->type == 2 ? 'selected' : '' : '' }}>Bank</option>
                                    <option value="3" {{ $account ?? '' ? $account->type == 3 ? 'selected' : '' : '' }}>Mobile Payment</option>
                                    <option value="4" {{ $account ?? '' ? $account->type == 4 ? 'selected' : '' : '' }}>Credit Card</option>
                                </select>

                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="icon" class="col-md-4 col-form-label text-md-right">Icon</label>

                            <div class="col-md-6">
                                <input id="icon" type="file" class="form-control @error('icon') is-invalid @enderror" name="icon" autocomplete="icon">

                                @error('icon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="balance" class="col-md-4 col-form-label text-md-right">Starting Balance</label>

                            <div class="col-md-6">
                                <input id="balance" type="number" value="{{ $account ?? '' ? $account->balance : '0.00'}}" step="0.01" class="form-control @error('balance') is-invalid @enderror" name="balance" autocomplete="balance">

                                @error('balance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ $account ?? '' ? 'Save' : 'Add'}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
