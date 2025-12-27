@extends('layouts.web.user-portal.main-layout')

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('login-activities.index') }}">Login Activities</a>
                    </li>
                    <li class="breadcrumb-item active">Activity Details</li>
                </ol>
            </nav>

            <!-- Activity Details Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Login Activity Details</h5>
                        <div>
                            @if($loginActivity->successful)
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>Successful Login
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle me-1"></i>Failed Login
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Left Column - Basic Info -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Login Information</h6>
                            
                            <div class="mb-3">
                                <label class="text-muted small">Date & Time</label>
                                <div class="fw-semibold">
                                    {{ $loginActivity->login_at->format('F j, Y') }}
                                    <br>
                                    <small class="text-muted">{{ $loginActivity->login_at->format('g:i:s A') }}</small>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="text-muted small">IP Address</label>
                                <div>
                                    <code>{{ $loginActivity->ip_address }}</code>
                                    <button class="btn btn-sm btn-outline-secondary ms-2" 
                                            onclick="copyToClipboard('{{ $loginActivity->ip_address }}')">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                            </div>
                            
                            @if($loginActivity->logout_at)
                            <div class="mb-3">
                                <label class="text-muted small">Logout Time</label>
                                <div class="fw-semibold">
                                    {{ $loginActivity->logout_at->format('F j, Y g:i:s A') }}
                                </div>
                            </div>
                            @endif
                            
                            @if($loginActivity->failure_reason)
                            <div class="mb-3">
                                <label class="text-muted small">Failure Reason</label>
                                <div class="text-danger">
                                    {{ $loginActivity->failure_reason }}
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Right Column - Device Info -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Device & Browser Information</h6>
                            
                            @if($loginActivity->browser)
                            <div class="mb-3">
                                <label class="text-muted small">Browser</label>
                                <div class="fw-semibold">
                                    <i class="bi bi-browser-chrome me-2"></i>
                                    {{ $loginActivity->browser }}
                                </div>
                            </div>
                            @endif
                            
                            @if($loginActivity->platform)
                            <div class="mb-3">
                                <label class="text-muted small">Operating System</label>
                                <div class="fw-semibold">
                                    <i class="bi bi-laptop me-2"></i>
                                    {{ $loginActivity->platform }}
                                </div>
                            </div>
                            @endif
                            
                            @if($loginActivity->device)
                            <div class="mb-3">
                                <label class="text-muted small">Device Type</label>
                                <div class="fw-semibold">
                                    <i class="bi bi-phone me-2"></i>
                                    {{ $loginActivity->device }}
                                </div>
                            </div>
                            @endif
                            
                            @if($loginActivity->location)
                            <div class="mb-3">
                                <label class="text-muted small">Location</label>
                                <div class="fw-semibold">
                                    <i class="bi bi-geo-alt me-2"></i>
                                    {{ $loginActivity->location }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- User Agent Information -->
                    @if($loginActivity->user_agent)
                    <hr class="my-4">
                    <h6 class="text-muted mb-3">Technical Details</h6>
                    
                    <div class="mb-3">
                        <label class="text-muted small">User Agent String</label>
                        <div class="bg-light p-3 rounded">
                            <code class="small">{{ $loginActivity->user_agent }}</code>
                        </div>
                    </div>
                    @endif
                    
                    @if($loginActivity->session_id)
                    <div class="mb-3">
                        <label class="text-muted small">Session ID</label>
                        <div>
                            <code>{{ $loginActivity->session_id }}</code>
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('login-activities.index') }}" 
                           class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back to Activities
                        </a>
                        
                        @if(!$loginActivity->successful && $loginActivity->failure_reason)
                        <button class="btn btn-outline-warning" 
                                onclick="alert('Security feature: Report suspicious activity')">
                            <i class="bi bi-shield-exclamation me-2"></i>Report Suspicious Activity
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success feedback
        const btn = event.target.closest('button');
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check"></i> Copied!';
        btn.classList.add('btn-success');
        btn.classList.remove('btn-outline-secondary');
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    });
}
</script>
@endsection
