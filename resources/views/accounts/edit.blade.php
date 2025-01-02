<form id="editAccountForm" role="form text-left" method="POST" action="">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-sm-12 col-lg-6 form-group">
            <label for="editName">Name</label>
            <input type="text" class="form-control" placeholder="Account Name" name="name"
                id="editName" required>
        </div>
        <div class="col-sm-12 col-lg-6 form-group form-group">
            <label for="editType">Account Type</label>
            <select name="type" class="form-select form-control" id="editType">
                @foreach (config('custom.account_types') as $value => $text)
                    <option value="{{ $value }}">{{ $text['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-lg-6 form-group">
            <label for="editBalance">Initial Amount</label>
            <input type="number" class="form-control" placeholder="0" name="balance" id="editBalance"
                step="0.01" required>
        </div>
        <div class="col-sm-12 col-lg-6 form-group">
            <label for="editCurrency">Currency</label>
            <select name="currency" class="form-select form-control" id="editCurrency" required>
                @foreach (config('custom.currencies') as $code => $currency)
                    <option value="{{ $code }}">{{ $currency }} - {{ $code }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="text-center">
        <button type="submit" id="updateAccountBtn"
            class="btn bg-gradient-primary w-100 mt-4 mb-0">Update</button>
    </div>
</form>