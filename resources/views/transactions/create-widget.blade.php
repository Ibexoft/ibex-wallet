<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $pageTitle }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('transactions.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">Type <span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required autocomplete="type" autofocus>
                                    <option value="1" {{ old('type') == '1' ? 'selected' : ''}}>Expense</option>
                                    <option value="2" {{ old('type') == '2' ? 'selected' : ''}}>Income</option>
                                    <option value="3" {{ old('type') == '3' ? 'selected' : ''}}>Transfer</option>
                                </select>

                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">Amount <span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="amount" type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" required autocomplete="amount">

                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category_id" class="col-md-4 col-form-label text-md-right">Expense</label>

                            <div class="col-md-6">
                                <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" autocomplete="category_id">
                                    <option></option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="details" class="col-md-4 col-form-label text-md-right">Details</label>

                            <div class="col-md-6">
                                <input id="details" type="text" class="form-control @error('details') is-invalid @enderror" name="details" autocomplete="details">

                                @error('details')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="src_account_id" class="col-md-4 col-form-label text-md-right">Account <span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <select name="src_account_id" id="src_account_id" class="form-control @error('src_account_id') is-invalid @enderror" required autocomplete="src_account_id">
                                    {{-- <option></option> --}}
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>

                                @error('src_account_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dest_account_id" class="col-md-4 col-form-label text-md-right">To Account</label>

                            <div class="col-md-6">
                                <select name="dest_account_id" id="dest_account_id" class="form-control @error('dest_account_id') is-invalid @enderror" autocomplete="dest_account_id">
                                    <option></option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>

                                @error('dest_account_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="wallet_id" class="col-md-4 col-form-label text-md-right">Wallet <span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <select name="wallet_id" id="wallet_id" class="form-control @error('wallet_id') is-invalid @enderror" required autocomplete="wallet_id">
                                    <!-- <option></option> -->
                                    @foreach ($wallets as $wallet)
                                        <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                                    @endforeach
                                </select>


                                @error('wallet_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="spent_on" class="col-md-4 col-form-label text-md-right">Spent On</label>

                            <div class="col-md-6">
                                <input id="spent_on" type="text" class="form-control @error('spent_on') is-invalid @enderror" name="spent_on" autocomplete="spent_on">

                                @error('spent_on')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
