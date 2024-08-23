<div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header px-5">
                <h6 class="modal-title" id="modal-title-default">ADD ACCOUNT</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body px-5">
                <form id="accountForm" role="form text-left" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 col-lg-9 form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" placeholder="Account Name" name="name" id="name" required>
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                            <label for="color">Color</label>
                            <input style="height: 2.5rem;" type="color" value="#cb0c9f" class="form-control"
                                aria-label="Color" aria-describedby="color-addon" name="color" id="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Type">Account type</label>
                        <select name="type" class="form-select form-control">
                            @foreach (config('custom.account_types') as $value => $text)
                                <option value="{{ $value }}">{{ $text }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-lg-9 form-group">
                            <label for="balance">Initial amount</label>
                            <input type="number" class="form-control" placeholder="0" name="balance" id="balance" required>
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                            <label for="Type">Currency</label>
                            <select name="currency" class="form-select form-control">
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency }}">{{ $currency }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" id="saveAccountBtn"
                            class="btn bg-gradient-primary w-100 mt-4 mb-0"
                            onclick="saveAccount()">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
