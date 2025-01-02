<form method="post" id="updatePasswordForm" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="mb-3">
        <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
        <input type="password" id="update_password_current_password" name="current_password" class="form-control mt-1"
            autocomplete="current-password" required>
        @error('current_password')
            <div class="text-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
        <input type="password" id="update_password_password" name="password" class="form-control mt-1"
            autocomplete="new-password" required>
        @error('password')
            <div class="text-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
        <input type="password" id="update_password_password_confirmation" name="password_confirmation"
            class="form-control mt-1" autocomplete="new-password" required>
        @error('password_confirmation')
            <div class="text-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary w-100">{{ __('Save') }}</button>
</form>
</div>
