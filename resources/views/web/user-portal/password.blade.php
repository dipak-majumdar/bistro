@extends('layouts.web.user-portal.main-layout')

@section('main')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>{{ __('Update Password') }}</h4>
        </div>

        <!-- Update Password Card -->
        <x-web.profile.update-password-form />

    </div>
@endsection
