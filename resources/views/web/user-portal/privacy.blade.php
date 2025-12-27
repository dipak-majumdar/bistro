@extends('layouts.web.user-portal.main-layout')

@section('main')
    <div class="container px-3 px-md-4">

        <!-- Account Security Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="mb-4">Security</h5>

                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <h6 class="mb-0">Two-Factor Authentication</h6>
                        <p class="small text-muted mb-0">Add an extra layer of security to your account
                        </p>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="twoFactorSwitch"
                            {{ Auth::user()->two_factor_enabled ? 'checked' : '' }}>
                        <label class="form-check-label" for="twoFactorSwitch"></label>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <h6 class="mb-0">Login Notifications</h6>
                        <p class="small text-muted mb-0">Get notified when someone logs into your
                            account</p>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="loginNotificationsSwitch"
                            checked>
                        <label class="form-check-label" for="loginNotificationsSwitch"></label>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Account Activity</h6>
                        <p class="small text-muted mb-0">Last login:
                            {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'Never' }}
                        </p>
                    </div>
                    <a href="{{ route('login-activities.index') }}" class="btn btn-outline-secondary btn-sm">
                        View Activity
                    </a>
                </div>
            </div>
        </div>

        <!-- Delete Account Card -->
        <div class="card border-danger shadow-sm">
            <div class="card-body p-4">
                <x-web.profile.delete-user-form />
            </div>
        </div>

    </div>
@endsection
