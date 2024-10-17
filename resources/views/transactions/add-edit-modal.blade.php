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
                @include("transactions.create-widget")
            </div>
        </div>
    </div>
</div>
