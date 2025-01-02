@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="page-header border-radius-lg mt-4 d-flex flex-column justify-content-end">
            <span class="mask bg-primary opacity-9"></span>
            <div class="w-100 position-relative p-3">
                <div class="d-lg-flex justify-content-between align-items-end">
                    <div class="d-flex align-items-center">
                        <form id="profileImageUpdateForm"
                            action="{{ route('profile.updateImage', ['profile' => Auth::user()->id]) }}" method="POST"
                            enctype="multipart/form-data"
                            class="avatar avatar-xl bg-white shadow-md border overflow-hidden position-relative me-3 cursor-pointer"
                            onclick="document.getElementById('profileImageInput').click()">
                            @csrf
                            @method('PUT')
                            <img id="profileImage"
                                src="{{ $user->image ? asset('storage/' . $user->image) : asset('assets/img/user-placeholder.png') }}"
                                alt="profile_image" class="w-100 border-radius-lg">
                            <input type="file" id="profileImageInput" name="image" class="d-none" accept="image/*"
                                onchange="this.closest('form').submit();">
                        </form>
                        <div>
                            <h5 class="text-white font-weight-bolder mb-0">
                                {{ $user->name }}
                            </h5>
                            <p class="text-white text-sm">
                                {{ $user->email }}
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center float-end">
                        <a href="javascript:;" class="btn btn-outline-white mb-0 me-1 btn-sm" data-bs-toggle="modal"
                            data-bs-target="#ProfileUpdatePasswordModal">
                            Update Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row align-items-start">
            <div class="col-12 col-xl-12 mb-4">
                <div class="card h-100 p-2">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-0">Profile Information</h6>
                            </div>
                            <div class="col-md-4 text-end">
                                <button id="profile-edit-btn" class="btn btn-outline-secondary mb-0 btn-sm"
                                    onclick="toggleEditMode()">
                                    Edit
                                </button>
                                <button id="profile-cancel-btn" class="btn btn-outline-secondary mb-0 btn-sm d-none"
                                    onclick="toggleEditMode()">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <form id="profile-form" method="POST"
                            action="{{ route('profile.update', ['profile' => Auth::user()->id]) }}">
                            @csrf
                            @method('PUT')
                            <ul class="list-group">
                                <li class="list-group-item border-0 ps-0 pt-0 text-sm d-flex align-items-center">
                                    <strong class="text-dark me-3">Full Name:</strong>
                                    <div class="flex-grow-1">
                                        <span id="name-view">{{ $user->name }}</span>
                                        <input id="name-input" name="name" type="text"
                                            class="form-control d-none" value="{{ $user->name }}" placeholder="{{$user->name}}">
                                    </div>
                                </li>
                                <li class="list-group-item border-0 ps-0 pt-0 text-sm d-flex align-items-center">
                                    <strong class="text-dark me-3">Email:</strong>
                                    &nbsp;
                                    <div class="flex-grow-1">
                                        <span id="email-view">{{ $user->email }}</span>
                                        <input id="email-input" name="email" type="email"
                                            class="form-control d-none" value="{{ $user->email }}" placeholder="{{ $user->email }}">
                                    </div>
                                </li>
                            </ul>
                            <div class="text-end px-3">
                                <button id="profile-save-btn" type="submit" class="btn bg-primary text-white mt-2 btn-sm d-none">
                                    Save
                                </button>
                            </div>
                        </form>
                        <li class="list-group-item border-0 ps-0 pt-0 text-sm d-flex align-items-center">
                            <strong class="text-dark me-3">Created at:</strong>
                            &nbsp;
                            <div class="flex-grow-1">
                                <span>{{ \Carbon\Carbon::parse($user->created_at)->format('d-M-Y') }}</span>
                            </div>
                        </li>

                        <div class="d-flex justify-content-end mt-4">
                            <form action="{{ route('profile.destroy', ['profile' => Auth::user()->id]) }}" method="POST"
                                id="delete-profile-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger mb-0  btn-sm"
                                    onclick="confirmDeletion(event)">
                                    Delete Account
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('profile.partials.update-password-modal')
    @include('profile.partials.delete-toast')
@endsection

<script>
    let profiledeleteTimeout;
    let countdown = 5;

    function confirmDeletion(event) {
        event.preventDefault();

        swalForDeleteConfirmation
            .fire({
                title: "Are you sure?",
                text: "You want to delete your profile?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
            })
            .then((result) => {
                if (result.isConfirmed) {
                    const toastElement = new bootstrap.Toast(document.getElementById('profileDeleteToast'));
                    toastElement.show();

                    // Countdown display
                    const countdownElement = document.getElementById('delete-countdown');
                    countdownElement.textContent = countdown;

                    profiledeleteTimeout = setInterval(() => {
                        countdown--;
                        countdownElement.textContent = countdown;
                        if (countdown <= 0) {
                            clearInterval(profiledeleteTimeout);
                            document.getElementById('delete-profile-form').submit();
                        }
                    }, 1000);
                }
            });
    }

    function cancelDeletion() {
        clearInterval(profiledeleteTimeout);
        countdown = 5;
        const toastElement = new bootstrap.Toast(document.getElementById('profileDeleteToast'));
        toastElement.hide();
    }

    document.addEventListener("DOMContentLoaded", function() {
        if ("{{ session('status') }}" === 'password-updated') {
            showToast("Password Updated Successfully");
        }

        const errors = @json($errors->updatePassword->all());
        if (errors.length > 0) {
            let errorList = "";
            errors.forEach(error => {
                errorList += `<p class="mb-0">${error}</p>`;
            });

            swalWithBootstrapButtons.fire({
                title: "Validation Errors",
                html: errorList,
                icon: "error",
            });
        }
    });
</script>
