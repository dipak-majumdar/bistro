@extends('layouts.web.user-portal.main-layout')

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Login Activities</h4>
                <div class="d-flex gap-2">
                    <!-- Period Filter -->
                    <select class="form-select form-select-sm" onchange="window.location.href='?period='+this.value">
                        <option value="">All Time</option>
                        <option value="7" {{ request('period') == '7' ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="30" {{ request('period') == '30' ? 'selected' : '' }}>Last 30 Days</option>
                        <option value="90" {{ request('period') == '90' ? 'selected' : '' }}>Last 90 Days</option>
                    </select>
                    
                    <!-- Status Filter -->
                    <select class="form-select form-select-sm" onchange="window.location.href='?status='+this.value">
                        <option value="">All Activities</option>
                        <option value="successful" {{ request('status') == 'successful' ? 'selected' : '' }}>Successful</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                    <i class="bi bi-box-arrow-in-right text-primary fs-5"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-0 small">Total Logins</p>
                                    <h5 class="mb-0">{{ $stats['total_logins'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 p-3 rounded-3 me-3">
                                    <i class="bi bi-check-circle text-success fs-5"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-0 small">Successful</p>
                                    <h5 class="mb-0">{{ $stats['successful_logins'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-danger bg-opacity-10 p-3 rounded-3 me-3">
                                    <i class="bi bi-x-circle text-danger fs-5"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-0 small">Failed</p>
                                    <h5 class="mb-0">{{ $stats['failed_logins'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 p-3 rounded-3 me-3">
                                    <i class="bi bi-geo-alt text-info fs-5"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-0 small">Unique IPs</p>
                                    <h5 class="mb-0">{{ $stats['unique_ips'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Last Login Info -->
            @if($stats['last_login'])
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-info-circle me-2"></i>
                    <div>
                        <strong>Last successful login:</strong> {{ $stats['last_login']->login_at->format('M j, Y g:i A') }}
                        from {{ $stats['last_login']->ip_address }}
                        @if($stats['last_login']->browser)
                            using {{ $stats['last_login']->browser }}
                        @endif
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Activities Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date & Time</th>
                                    <th>Status</th>
                                    <th>IP Address</th>
                                    <th>Browser/Device</th>
                                    <th>Location</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activities as $activity)
                                <tr>
                                    <td>
                                        <div>{{ $activity->login_at->format('M j, Y') }}</div>
                                        <small class="text-muted">{{ $activity->login_at->format('g:i A') }}</small>
                                    </td>
                                    <td>
                                        @if($activity->successful)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Success
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle me-1"></i>Failed
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <code>{{ $activity->ip_address }}</code>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            @if($activity->browser)
                                                <i class="bi bi-browser-chrome text-muted"></i>
                                                <small>{{ $activity->browser }}</small>
                                            @endif
                                            @if($activity->platform)
                                                <small class="text-muted">on {{ $activity->platform }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($activity->location)
                                            <small>{{ $activity->location }}</small>
                                        @else
                                            <span class="text-muted">Unknown</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('login-activities.show', $activity) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            No login activities found
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $activities->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
