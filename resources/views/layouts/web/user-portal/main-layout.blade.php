<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="FooYes - Quality delivery or takeaway food">
    <meta name="author" content="Dipak Majumdar">
    <title>{{ config('app.name') }} - Quality delivery or takeaway food</title>

    <x-web.header-link />
    @yield('header')
    <style>
        .hover-shadow {
            transition: all 0.3s ease;
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
        }
    </style>
</head>

<body>
    {{-- @yield('navbar') --}}
    <x-web.navbar />

    <main>
        <section class="container mt-5 p-3 p-md-4">

            <!-- Settings Tab -->
            <div class="mt-5">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body text-start">
                                <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                                <p class="text-muted mb-3"><i class="bi bi-telephone me-2 text-main"></i>{{ Auth::user()->mobile }}</p>
                                {{-- <p class="text-muted mb-3"><i class="bi bi-envelope me-2 text-main"></i>{{ Auth::user()->email }}</p> --}}
                                <div class="d-flex justify-content-start gap-2">
                                    <span class="badge bg-light text-dark fw-normal">
                                        <i class="fas fa-star text-warning me-1"></i>
                                        {{ Auth::user()->loyalty_tier ?? 'Silver' }} Member
                                    </span>
                                    <span class="badge bg-light text-dark fw-normal">
                                        <i class="fas fa-award text-primary me-1"></i>
                                        {{ Auth::user()->reward_points ?? '0' }} Points
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="row g-2 mb-4">
                            <!-- Order Stats Card -->
                            <div class="col-6">
                                <div class="card border-0 shadow-sm h-100 hover-shadow">
                                    <div class="card-body py-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="bg-primary bg-opacity-10 px-3 py-2 rounded-3">
                                                <i class="bi bi-bag-check-fill text-primary fs-5"></i>
                                            </div>
                                            <div class="text-end">
                                                <p class="text-sm fw-semibold mb-0">Total Orders</p>
                                                <h3 class="fs-6 mb-0">{{ $stats['total_orders'] ?? 0 }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Favorites Card -->
                            <div class="col-6">
                                <div class="card border-0 shadow-sm h-100 hover-shadow">
                                    <div class="card-body py-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="bg-success bg-opacity-10 px-3 py-2 rounded-3">
                                                <i class="bi bi-heart-fill text-success fs-5"></i>
                                            </div>
                                            <div class="text-end">
                                                <p class="fw-semibold mb-0">Favorites</p>
                                                <h6 class="mb-0">{{ $stats['favorites_count'] ?? 0 }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="card border-0 shadow-sm mb-2">
                            <div class="card-body d-flex justify-content-between">
                                <h6 class="mb-0">Profile</h6>
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </a>

                        <a href="{{ route('orders') }}" class="card border-0 shadow-sm mb-2">
                            <div class="card-body d-flex justify-content-between">
                                <h6 class="mb-0">My Orders</h6>
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </a>
                        <a href="#" class="card border-0 shadow-sm mb-2">
                            <div class="card-body d-flex justify-content-between">
                                <h6 class="mb-0">Wishlist</h6>
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </a>

                        <a href="{{ route('profile.address-book') }}" class="card border-0 shadow-sm mb-2">
                            <div class="card-body d-flex justify-content-between">
                                <h6 class="mb-0">Addresses Book</h6>
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </a>

                        <a href="{{ route('user.password') }}" class="card border-0 shadow-sm mb-2">
                            <div class="card-body d-flex justify-content-between">
                                <h6 class="mb-0">Change Password</h6>
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </a>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="mb-3">Quick Actions</h6>
                                <div class="list-group list-group-flush">
                                    
                                    <a href="{{ route('support') }}" class="list-group-item list-group-item-action border-0 px-2">
                                        <i class="bi bi-headset me-2"></i> Support
                                    </a>
                                    <button type="button" class="list-group-item list-group-item-action border-0 px-2"
                                        onclick="shareApp(event)">
                                        <i class="bi bi-share-fill me-2"></i> Share App
                                    </button>

                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="list-group-item list-group-item-action border-0 px-2">
                                        <i class="bi bi-power me-2"></i>Logout
                                        </button>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">

                        @yield('main')

                    </div>
                </div>
            </div>

        </section>

    </main>
    <!-- /main -->

    <div id="toTop"></div><!-- Back to top button -->

    @yield('elements')

    <!-- Global Toast Component -->
    <x-web.component.toast />

    <!-- COMMON SCRIPTS -->
    <x-web.footer-js-links />

    @yield('custom-js')

    <!-- Autocomplete -->
    <script>
        @if (session('success'))
            window.showToast('{{ session('success') }}', {
                variant: 'success',
                delay: 4000
            });
        @endif

        @if (session('error'))
            window.showToast('{{ session('error') }}', {
                variant: 'danger',
                delay: 4000
            });
        @endif
        
        // Function to cancel order
        function cancelOrder(orderId) {
            if (confirm('Are you sure you want to cancel this order?')) {
                fetch(`/orders/${orderId}/cancel`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload the page to reflect changes
                            window.location.reload();
                        } else {
                            alert(data.message || 'Failed to cancel order. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while processing your request.');
                    });
            }
        }
        // Initialize Bootstrap tabs if needed
        document.addEventListener('DOMContentLoaded', function() {
            var tabEls = [].slice.call(document.querySelectorAll('button[data-bs-toggle="tab"]'));
            tabEls.forEach(function(tabEl) {
                new bootstrap.Tab(tabEl);
            });
        });


        // Share App Function
        function shareApp(event) {
            event.preventDefault();
            event.stopPropagation();
            
            const appUrl = window.location.origin;
            const appName = '{{ config('app.name') }}';
            const shareData = {
                title: appName,
                text: `Check out ${appName} - Quality delivery or takeaway food`,
                url: appUrl
            };

            if (navigator.share) {
                // Use native share API (mobile devices)
                navigator.share(shareData)
                    .then(() => console.log('Shared successfully'))
                    .catch((error) => console.log('Error sharing:', error));
            } else {
                // Fallback for desktop - copy to clipboard
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(appUrl).then(() => {
                        // Show success message
                        showToast('Application URL copied to clipboard!', {
                            variant: 'success',
                            delay: 3000
                        });
                    }).catch(() => {
                        // Fallback to manual copy
                        prompt('Copy this URL to share:', appUrl);
                    });
                } else {
                    // Final fallback
                    prompt('Copy this URL to share:', appUrl);
                }
            }
            
            return false;
        }
    </script>

</body>

</html>
