@php
use App\Enums\TransactionType as TransactionType;
@endphp
<form class="transactionForm" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="transaction_id" name="transaction_id">

    <div class="row">
        <div class="btn-group btn-group-toggle mx-auto" data-toggle="buttons">
            <label class="btn btn-outline-primary px-1 mx-0 {{ session('transaction_type') === TransactionType::Expense->label() || !session('transaction_type') ? 'active' : '' }}" id="expense-btn">
                <input type="radio" class="d-none" name="type"
                    value="{{ TransactionType::Expense->label() }}" {{ session('transaction_type') === TransactionType::Expense->label() || !session('transaction_type') ? 'checked' : '' }}
                    onclick="changeTransactionType('{{ TransactionType::Expense->label() }}', this.parentElement.parentElement.parentElement.parentElement)">
                Expense
            </label>
            <label class="btn btn-outline-primary px-1 {{ session('transaction_type') === TransactionType::Income->label() ? 'active' : '' }}" id="income-btn">
                <input type="radio" class="d-none" name="type"
                    value="{{ TransactionType::Income->label() }}" {{ session('transaction_type') === TransactionType::Income->label() ? 'checked' : '' }}
                    onclick="changeTransactionType('{{ TransactionType::Income->label() }}', this.parentElement.parentElement.parentElement.parentElement)">
                Income
            </label>
            <label class="btn btn-outline-primary px-1 {{ session('transaction_type') === TransactionType::Transfer->label() ? 'active' : '' }}" id="transfer-btn">
                <input type="radio" class="d-none" name="type"
                    value="{{ TransactionType::Transfer->label() }}" {{ session('transaction_type') === TransactionType::Transfer->label() ? 'checked' : '' }}
                    onclick="changeTransactionType('{{ TransactionType::Transfer->label() }}', this.parentElement.parentElement.parentElement.parentElement)">
                Transfer
            </label>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <label for="transaction_date">Date <span class="text-danger">*</span></label>
            <input id="transaction_date" type="date" class="form-control" name="transaction_date"
                value="{{ session('transaction_date', date('Y-m-d')) }}" required autocomplete="transaction_date">
        </div>

        <div class="col-4 form-group" id="amount-field">
            <label for="amount">Amount <span class="text-danger">*</span></label>
            <input id="amount" type="number" min="0" step="0.01" class="form-control"
                placeholder="0.00" name="amount" required autocomplete="amount">
        </div>

        <div class="col-8 form-group">
            <label for="src_account_id" id="account-label">Account <span
                    class="text-danger">*</span></label>
            <select name="src_account_id" id="src_account_id" class="form-control" required
                autocomplete="src_account_id">
                <option selected disabled value="">-- Select Account --</option>
                @foreach ($accounts as $account)
                    <option value="{{ $account->id }}" {{ session('src_account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 form-group" id="collapseToAccount" style="display: none;">
            <label for="dest_account_id">To Account <span class="text-danger">*</span></label>
            <select name="dest_account_id" id="dest_account_id" class="form-control"
                autocomplete="dest_account_id">
                <option selected disabled>-- Select Account --</option>
                @foreach ($accounts as $account)
                    <option value="{{ $account->id }}" {{ session('dest_account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12 form-group" id="category-field">
            <label for="category_id">Category <span class="text-danger">*</span></label>
            <select name="category_id" id="category_id" class="form-control"
                autocomplete="category_id" required>
                <option selected disabled value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ session('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @if (count($category->subcategories))
                        @include ('categories.subCategoryOption', [
                            'subcategories' => $category->subcategories,
                            'indent' => 1,
                        ])
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <input id="details" type="text" class="form-control" name="details" maxlength="200"
                autocomplete="details" placeholder="Details (optional)" title="Details about the transaction">
        </div>
    </div>

    <div class="text-center">
        <button type="submit" id="transactionModalSubmitBtn"
            class="btn bg-gradient-primary w-100">Add</button>
    </div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let selectedTransactionType = "{{ session('transaction_type') }}";
        changeTransactionType(selectedTransactionType, document.querySelector('.transactionForm'));

        // To account and From account cannot be the same
        const srcAccountDropdown = document.getElementById('src_account_id');
        const destAccountDropdown = document.getElementById('dest_account_id');

        srcAccountDropdown.addEventListener('change', () => {
            filterDestinationOptions(srcAccountDropdown, destAccountDropdown);
        });

        filterDestinationOptions(srcAccountDropdown, destAccountDropdown);
    });
</script>