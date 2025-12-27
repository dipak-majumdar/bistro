@extends('layouts.web.user-portal.main-layout')

@section('main')
    <div class="container px-3 px-md-4">

        <!-- Profile Information Card -->
        <x-web.profile.update-profile-information-form :user="$user" />
        
        <!-- Account Security Card -->
        <div class="card rounded shadow-sm mb-4">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Account Activity</h6>
                        <p class="small text-muted mb-0">Last login:
                            {{ Auth::user()->loginActivities()->successful()->latest('login_at')->first()?->login_at?->diffForHumans() ?? 'Never' }}
                        </p>
                    </div>
                    <a href="{{ route('login-activities.index') }}" class="btn btn-outline-secondary btn-sm">
                        View Activity
                    </a>
                </div>
            </div>
        </div>

        <!-- Delete Account Card -->
        <div class="card rounded shadow-sm">
            <div class="card-body p-4">
                <x-web.profile.delete-user-form />
            </div>
        </div>

    </div>
@endsection
