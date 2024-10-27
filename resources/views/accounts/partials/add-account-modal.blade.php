<div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header px-5">
                <h6 class="modal-title" id="modal-title-default">Add Account</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body px-5">
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
                            <select name="type" class="form-select form-control">
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
                                <option></option>
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
            </div>
        </div>
    </div>
</div>
