<form id="accountForm" role="form text-left" method="POST">
    @csrf
    <div class="row">
        <div class="col-sm-12 col-lg-6 form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" placeholder="Account Name" name="name"
                id="name" required>
        </div>
        <div class="col-sm-12 col-lg-6 form-group">
            <label for="Type">Account type</label>
            <select name="type" class="form-select form-control" required>
                <option selected disbaled value="">-- Select Account Type --</option>
                @foreach (config('custom.account_types') as $value => $text)
                    <option value="{{ $value }}">{{ $text['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-lg-6 form-group">
            <label for="balance">Initial amount</label>
            <input type="number" class="form-control" placeholder="0" name="balance" id="balance"
                step="0.01" value="0.00" required>
        </div>
        <div class="col-sm-12 col-lg-6 form-group">
            <label for="Type">Currency</label>
            <select name="currency" class="form-select form-control" required>
                <option selected disabled value="">-- Select Currency --</option>
                @foreach ($currencies as $code => $currency)
                    <option value="{{ $code }}">{{ $code }} - {{ $currency }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="text-center">
        <button type="submit" id="saveAccountBtn"
            class="btn bg-gradient-primary w-100 mt-4 mb-0">Add</button>
    </div>
</form>