<div class="modal fade" id="ProfileUpdatePasswordModal" tabindex="-1" role="dialog" aria-labelledby="updatePasswordModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header px-5">
                <h6 class="modal-title" id="ProfileUpdatePasswordTitle">Update Password</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body px-5">
                @include("profile.partials.update-password-form")
            </div>
        </div>
    </div>
</div>