<div class="card">
    <div class="card-body">
        <h2 class="h5 mb-4">{{ __('Profile Information') }}</h2>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" class="needs-validation" novalidate>
            @csrf
            @method('patch')

            <div class="mb-3">
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $user->name) }}" 
                       required 
                       autofocus 
                       autocomplete="name"
                       placeholder="Enter your name">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <input type="number" 
                       class="form-control @error('mobile') is-invalid @enderror" 
                       id="mobile" 
                       name="mobile" 
                       value="{{ old('mobile', $user->mobile) }}" 
                       required 
                       autofocus 
                       autocomplete="mobile"
                       placeholder="Enter mobile">
                @error('mobile')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="alert alert-warning mt-2">
                        <p class="mb-1">{{ __('Your email address is unverified.') }}</p>
                        <button form="send-verification" class="btn btn-sm btn-outline-warning">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                        @if (session('status') === 'verification-link-sent')
                            <div class="alert alert-success mt-2 mb-0">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="d-flex align-items-center gap-3 text-end">
                <button type="submit" class="btn btn-sm btn-primary ms-auto">
                    {{ __('Save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
@endpush