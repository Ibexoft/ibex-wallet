<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-edit" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header px-5">
                <h6 class="modal-title" id="modal-title-edit">EDIT ACCOUNT</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body px-5">
                <form id="editAccountForm" role="form text-left" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-12 col-lg-9 form-group">
                            <label for="editName">Name</label>
                            <input type="text" class="form-control" placeholder="Account Name" name="name"
                                id="editName" required>
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                            <label for="editColor">Color</label>
                            <input style="height: 2.5rem;" type="color" value="#cb0c9f" class="form-control"
                                aria-label="Color" aria-describedby="color-addon" name="color" id="editColor">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editType">Account Type</label>
                        <select name="type" class="form-select form-control" id="editType">
                            @foreach (config('custom.account_types') as $value => $text)
                                <option value="{{ $value }}">{{ $text }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-lg-9 form-group">
                            <label for="editBalance">Initial Amount</label>
                            <input type="number" class="form-control" placeholder="0" name="balance" id="editBalance"
                                required>
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                            <label for="editCurrency">Currency</label>
                            <select name="currency" class="form-select form-control" id="editCurrency" required>
                                @foreach (config('custom.currencies') as $value => $text)
                                    <option value="{{ $text }}">{{ $text }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" id="updateAccountBtn"
                            class="btn bg-gradient-primary w-100 mt-4 mb-0">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
