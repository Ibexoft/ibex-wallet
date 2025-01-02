{{-- Deletion Toast --}}
<div id="profileDeleteToast"
class="toast align-items-center text-white bg-gradient-primary border-0 position-fixed bottom-0 start-0 mb-3 ms-3"
role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
<div class="d-flex">
    <div id="profileDeleteToastBody" class="toast-body">
        Account deletion in progress... <span id="delete-countdown">5</span>
    </div>
    <a class="btn btn-link pe-3 my-1 ps-0  text-white ms-auto" onclick="cancelDeletion()">Undo</a>
</div>
</div>