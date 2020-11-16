<div class="card">
    <div class="card-header">{{ $transaction ?? '' ? 'Update' : 'Add'}} Transaction</div>

    <div class="card-body">
        <form method="POST"
            action="{{ $transaction ?? '' ? route('transactions.update', ['transaction' => $transaction->id]) : route('transactions.store') }}">
            @if ($transaction ?? '') @method('PUT') @endif
            @csrf

            <!-- ---------- EXPENSE TYPE ---------- -->

            <div class="form-group row">
                <div class="btn-group btn-group-toggle mx-auto" data-toggle="buttons">
                    <label
                        class="btn btn-secondary btn-lg {{ $transaction ?? '' ? ($transaction->type == '1' || old('type') == '1' ? 'active' : '') : 'active'}}">
                        <input type="radio" name="type" id="expense" value="1"
                            {{ $transaction ?? '' ? $transaction->type == '1' || old('type') == '1' ? 'checked' : '' : 'checked'}}
                            onclick="$('#collapseToAccount').collapse('hide')">
                        Expense
                    </label>
                    <label
                        class="btn btn-secondary btn-lg {{ $transaction ?? '' ? ($transaction->type == '2' || old('type') == '2' ? 'active' : '') : ''}}">
                        <input type="radio" name="type" id="income" value="2"
                            {{ $transaction ?? '' ? $transaction->type == '2' || old('type') == '2' ? 'checked' : '' : ''}}
                            onclick="$('#collapseToAccount').collapse('hide')">
                        Income
                    </label>
                    <label
                        class="btn btn-secondary btn-lg {{ $transaction ?? '' ? ($transaction->type == '3' || old('type') == '3' ? 'active' : '') : ''}}">
                        <input type="radio" name="type" id="transfer" value="3"
                            {{ $transaction ?? '' ? $transaction->type == '3' || old('type') == '3' ? 'checked' : '' : ''}}
                            onclick="$('#collapseToAccount').collapse('show')">
                        Transfer
                    </label>
                </div>
            </div>

            <!-- ---------- END EXPENSE TYPE ---------- -->


            <!-- ---------- DATE ---------- -->

            <div class="form-group">
                <label for="transaction_date" class="col-form-label">Date <span class="text-danger">*</span></label>

                <input id="transaction_date" type="date"
                    class="form-control @error('transaction_date') is-invalid @enderror" name="transaction_date"
                    value="{{ $transaction ?? '' ? $transaction->transaction_date ?? old('transaction_date') : date('Y-m-d')}}"
                    required autocomplete="transaction_date">

                @error('transaction_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>

            <!-- ---------- END DATE ---------- -->

            <!-- ---------- CATEGORY & DETAILS ---------- -->

            <div class="form-group">
                <label for="category_id" class="col-form-label">Expense</label>

                <select name="category_id" id="category_id"
                    class="form-control @error('category_id') is-invalid @enderror" autocomplete="category_id">
                    <option></option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $transaction ?? '' ? 
                                $transaction->category ?? '' ?
                                    $transaction->category->id == $category->id ? 'selected' : ''
                                    : '' 
                                : '' }}>
                        {{ $category->name }}</option>

                    @if (count($category->subcategories))
                    @include('categories.subCategoryOption',['subcategories' => $category->subcategories, 'indent'
                    => 1])
                    @endif
                    @endforeach
                </select>

                @error('category_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input id="details" type="text" class="form-control mt-3 @error('details') is-invalid @enderror"
                    name="details" value="{{ $transaction ?? '' ? $transaction->details : '' }}" autocomplete="details"
                    placeholder="Enter Details e.g. Eggs, bread, oil etc." title="Details about the transaction">

                @error('details')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- ---------- END CATEGORY & DETAILS ---------- -->

            <!-- ---------- AMOUNT ---------- -->

            <div class="form-group">
                <label for="amount" class="col-form-label">Amount <span class="text-danger">*</span></label>

                <input id="amount" type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                    name="amount" value="{{ $transaction ?? '' ? $transaction->amount ?? old('amount') : '' }}" required
                    autocomplete="amount">

                @error('amount')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- ---------- END AMOUNT ---------- -->

            <!-- ---------- ACCOUNT ---------- -->

            <div class="form-group">
                <label for="src_account_id" class="col-form-label">Account <span class="text-danger">*</span></label>

                <select name="src_account_id" id="src_account_id"
                    class="form-control @error('src_account_id') is-invalid @enderror" required
                    autocomplete="src_account_id">
                    @foreach ($accounts as $account)
                    <option value="{{ $account->id }}"
                        {{ $transaction ?? '' ? $transaction->src_account->id == $account->id ? 'selected' : '' : '' }}>
                        {{ $account->name }}</option>
                    @endforeach
                </select>

                @error('src_account_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- ---------- END ACCOUNT ---------- -->

            <!-- ---------- TO ACCOUNT ---------- -->

            <div class="collapse form-group" id="collapseToAccount">
                <label for="dest_account_id" class="col-form-label">To Account</label>

                <select name="dest_account_id" id="dest_account_id"
                    class="form-control @error('dest_account_id') is-invalid @enderror" autocomplete="dest_account_id">
                    <option></option>
                    @foreach ($accounts as $account)
                    <option value="{{ $account->id }}"
                        {{ $transaction ?? '' ? $transaction->dest_account && $transaction->dest_account->id == $account->id ? 'selected' : '' : '' }}>
                        {{ $account->name }}</option>
                    @endforeach
                </select>

                @error('dest_account_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- ---------- END TO ACCOUNT ---------- -->

            <!-- ---------- MORE ---------- -->

            <a class="" data-toggle="collapse" href="#collapseExtras" role="button">More...</a>

            <div class="collapse" id="collapseExtras">

                <!-- ---------- WALLET ---------- -->

                <div class="form-group">
                    <label for="wallet_id" class="col-form-label">Wallet <span class="text-danger">*</span></label>

                    <select name="wallet_id" id="wallet_id"
                        class="form-control @error('wallet_id') is-invalid @enderror" required autocomplete="wallet_id">

                        @foreach ($wallets as $wallet)
                        <option value="{{ $wallet->id }}"
                            {{ $transaction ?? '' ? $transaction->wallet->id == $wallet->id ? 'selected' : '' : '' }}>
                            {{ $wallet->name }}</option>
                        @endforeach
                    </select>

                    @error('wallet_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <!-- ---------- END WALLET ---------- -->

                <!-- ---------- SPENT ON ---------- -->

                <div class="form-group">
                    <label for="spent_on" class="col-form-label">Spent On</label>

                    <input id="spent_on" type="text" class="form-control @error('spent_on') is-invalid @enderror"
                        name="spent_on" value="{{ $transaction ?? '' ? $transaction->spent_on : '' }}"
                        autocomplete="spent_on">

                    @error('spent_on')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <!-- ---------- END SPENT ON ---------- -->

            </div>

            <!-- ---------- END MORE ---------- -->

            <!-- ---------- ADD BUTTON ---------- -->

            <div class="form-group row mb-0">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary float-right">
                        {{ $transaction ?? '' ? 'Update' : 'Add'}}
                    </button>
                </div>
            </div>

            <!-- ---------- END ADD BUTTON ---------- -->

        </form>
    </div>
</div>
