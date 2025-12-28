<div class="card shadow-sm">
    <div class="card-body">
        <form method="post" action="{{ route('password.update') }}" class="needs-validation" novalidate>
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
                <div class="input-group">
                    <input type="password" 
                           class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                           id="update_password_current_password" 
                           name="current_password" 
                           autocomplete="current-password">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('update_password_current_password', this)">
                        <i class="bi bi-eye" id="update_password_current_password-icon"></i>
                    </button>
                </div>
                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
                <div class="input-group">
                    <input type="password" 
                           class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                           id="update_password_password" 
                           name="password" 
                           autocomplete="new-password">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('update_password_password', this)">
                        <i class="bi bi-eye" id="update_password_password-icon"></i>
                    </button>
                </div>
                @error('password', 'updatePassword')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <div class="input-group">
                    <input type="password" 
                           class="form-control" 
                           id="update_password_password_confirmation" 
                           name="password_confirmation" 
                           autocomplete="new-password">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('update_password_password_confirmation', this)">
                        <i class="bi bi-eye" id="update_password_password_confirmation-icon"></i>
                    </button>
                </div>
            </div>

            <p class="text-muted small">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
            <div class="d-flex align-items-center justify-content-end gap-3">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="bi bi-floppy2 me-1"></i>
                    {{ __('Save') }}
                </button>

                @if (session('status') === 'password-updated')
                    <div class="text-success" id="password-save-message">
                        {{ __('Saved.') }}
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(inputId + '-icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
        button.title = 'Hide password';
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
        button.title = 'Show password';
    }
}
</script>

@push('scripts')
<script>
    // Auto-hide success message after 2 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const saveMessage = document.getElementById('password-save-message');
        if (saveMessage) {
            setTimeout(() => {
                saveMessage.style.display = 'none';
            }, 2000);
        }
    });
</script>
@endpush