<!-- Combined Modal for Add/Edit -->
<div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="transactionModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header px-5">
                <h6 class="modal-title" id="transactionModalTitle">New Transaction</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body px-5">
                <form id="transactionForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="transaction_id" name="transaction_id">
                    <!-- Hidden field for transaction ID -->
                    <div class="form-group row">
                        <div class="btn-group btn-group-toggle mx-auto" data-toggle="buttons">
                            <label class="btn btn-outline-primary active" id="expense-btn">
                                <input type="radio" class="d-none" name="type" value="1" checked
                                    onclick="changeTransactionType('expense')">
                                Expense
                            </label>
                            <label class="btn btn-outline-primary" id="income-btn">
                                <input type="radio" class="d-none" name="type" value="2"
                                    onclick="changeTransactionType('income')">
                                Income
                            </label>
                            <label class="btn btn-outline-primary" id="transfer-btn">
                                <input type="radio" class="d-none" name="type" value="3"
                                    onclick="changeTransactionType('transfer')">
                                Transfer
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 form-group">
                            <label for="src_account_id" id="account-label">Account <span
                                    class="text-danger">*</span></label>
                            <select name="src_account_id" id="src_account_id" class="form-control" required
                                autocomplete="src_account_id">
                                <option selected disabled value="">Select Account</option>
                                @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 form-group" id="collapseToAccount" style="display: none;">
                            <label for="dest_account_id">To Account <span class="text-danger">*</span></label>
                            <select name="dest_account_id" id="dest_account_id" class="form-control"
                                autocomplete="dest_account_id">
                                <option selected disabled>Select Account</option>
                                @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 form-group" id="amount-field">
                            <label for="amount">Amount <span class="text-danger">*</span></label>
                            <input id="amount" type="number" min="0" step="0.01" class="form-control"
                                placeholder="Enter Amount" name="amount" required autocomplete="amount">
                        </div>
                        <div class="col-6 form-group" id="category-field">
                            <label for="category_id">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-control"
                                autocomplete="category_id">
                                <option selected disabled value="">Select Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @if (count($category->subcategories))
                                @include ('categories.subCategoryOption', [
                                'subcategories' => $category->subcategories,
                                'indent' => 1,
                                ])
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 form-group" id="wallet-field">
                            <label for="wallet_id">Wallet</label>
                            <select name="wallet_id" id="wallet_id" class="form-control" required
                                autocomplete="wallet_id">
                                @foreach ($wallets as $wallet)
                                <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="details">Details</label>
                        <input id="details" type="text" class="form-control" name="details" maxlength="200"
                            autocomplete="details" placeholder="Enter Details" title="Details about the transaction">
                    </div>
                    <div class="form-group">
                        <label for="transaction_date">Date <span class="text-danger">*</span></label>
                        <input id="transaction_date" type="date" class="form-control" name="transaction_date"
                            value="{{ date('Y-m-d') }}" required autocomplete="transaction_date">
                    </div>
                    <div class="text-center">
                        <button type="submit" id="transactionModalSubmitBtn"
                            class="btn bg-gradient-primary w-100 w-md-50">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
