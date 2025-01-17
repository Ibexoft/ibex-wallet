<div class="modal fade" id="AddAccountModal" tabindex="-1" role="dialog" aria-labelledby="AddAccountModal" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header px-5">
                <h6 class="modal-title" id="modal-title-default">Add Account</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body px-5">
                @include('accounts.create')
            </div>
        </div>
    </div>
</div>
