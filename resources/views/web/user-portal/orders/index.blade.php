@extends('layouts.web.user-portal.main-layout')

@push('styles')
@endpush

@section('main')
    <style>
        .order-card {
            transition: all 0.3s ease-in-out;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid transparent;
            position: relative;
        }

        .order-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 10px;
            padding: 1px;
            background: linear-gradient(135deg, #0d6efd, transparent);
            -webkit-mask:
                linear-gradient(#fff 0 0) content-box,
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            pointer-events: none;
            /* This ensures clicks pass through to elements below */
            z-index: 0;
            /* Lower z-index than card content */
        }

        /* Ensure card content is above the pseudo-element */
        .order-card>* {
            position: relative;
            z-index: 1;
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1.5rem rgba(13, 110, 253, 0.1) !important;
        }

        .order-card:hover::before {
            opacity: 1;
        }

        /* .status-badge {
                                font-size: 0.75rem;
                                font-weight: 500;
                                letter-spacing: 0.5px;
                                padding: 0.35rem 0.75rem;
                            } */
        /* .hover-shadow {
                                transition: transform 0.2s ease, box-shadow 0.2s ease;
                            }
                            .hover-shadow:hover {
                                transform: translateY(-5px);
                                box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
                            } */
        .icon-box {
            transition: all 0.3s ease;
        }

        .card:hover .icon-box {
            transform: scale(1.1);
        }

        .accordion-button:not(.collapsed) {
            background-color: #f8f9fa;
            color: #0d6efd;
        }
    </style>
    <section class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ __('My Orders') }}</h4>
            <div>
                <div class="input-group input-group-sm" style="width: 250px;">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" class="form-control border-start-0" placeholder="Search orders..." id="orderSearch">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" data-filter="all">All Orders</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="processing">Processing</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="completed">Completed</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="cancelled">Cancelled</a></li>
                    </ul>
                </div>
            </div>
        </div>

        @if (isset($orders) && count($orders) > 0)
            <div class="row g-4" id="ordersContainer">
                @foreach ($orders as $order)
                    <div class="col-12 order-item" data-status="{{ strtolower($order->status) }}">
                        <div class="card border-0 shadow-sm order-card h-100">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="mb-1">Order #{{ $order->id }}</h5>
                                        <p class="text-muted small mb-0">
                                            Placed {{ $order->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <span
                                        class="badge rounded-pill status-badge bg-{{ $order->status == 'completed'
                                            ? 'success'
                                            : ($order->status == 'processing'
                                                ? 'primary'
                                                : ($order->status == 'cancelled'
                                                    ? 'danger'
                                                    : 'warning')) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>

                                <div class="row align-items-center mb-3">
                                    <div class="col-12">
                                        <div class="d-flex flex-wrap gap-2">
                                            @php $itemCount = 0; @endphp
                                            @foreach ($order->items as $eachitem)
                                                <div class="position-relative">
                                                    <img class="rounded"
                                                        src="{{ asset('storage/' . $eachitem->menuItem->primaryImage->image_path) }}"
                                                        alt="{{ $eachitem->menuItem->name }}"
                                                        style="width: 80px; height: 80px; object-fit: cover;">
                                                    <span
                                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                                        {{ $eachitem->quantity }}
                                                    </span>
                                                </div>
                                                @php $itemCount++; @endphp
                                                @if ($itemCount == 4)
                                                    @break
                                                @endif
                                            @endforeach
                                            @if (count($order->items) > 4)
                                                <div class="d-flex align-items-center justify-content-center rounded bg-light"
                                                    style="width: 80px; height: 80px;">
                                                    <span class="text-muted">+{{ count($order->items) - 4 }} more</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <div>
                                        <span class="fw-medium">Total:</span>
                                        <span
                                            class="text-primary fw-bold">₹{{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                    <div>
                                        <button class="btn btn-outline-primary btn-sm me-2 view-details"
                                            data-order-id="{{ $order->id }}">
                                            <i class="fas fa-eye me-1"></i> View Details
                                        </button>
                                        @if ($order->status == 'pending' || $order->status == 'processing')
                                            <button class="btn btn-outline-danger btn-sm"
                                                onclick="cancelOrder({{ $order->id }})">
                                                <i class="fas fa-times me-1"></i> Cancel
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <!-- Order details (initially hidden) -->
                                <div class="order-details card mb-4 d-none" id="order-details-{{ $order->id }}">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Order #{{ $order->id }} Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Items</h6>
                                                <ul class="list-group mb-3">
                                                    @foreach ($order->items as $item)
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h6 class="mb-0">{{ $item->menuItem->name }}</h6>
                                                                <span
                                                                    class="badge bg-light text-dark fw-normal">{{ $item->variations->first()->name }}</span>
                                                                <br>
                                                                <small class="text-muted">Qty:
                                                                    {{ $item->quantity }}</small>
                                                            </div>
                                                            <span>₹{{ number_format($item->price * $item->quantity, 2) }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Delivery Information <span
                                                        class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">{{ ucfirst($order->status) }}</span>
                                                </h6>
                                                <p class="mb-1">{{ $order->shipping_address->full_name ?? 'N/A' }}
                                                </p>
                                                <p class="mb-1">
                                                    {{ $order->shipping_address->address_line_1 ?? 'N/A' }}</p>
                                                <p class="mb-1">{{ $order->shipping_address->city ?? '' }},
                                                    {{ $order->shipping_address->state ?? '' }}
                                                    {{ $order->shipping_address->postal_code ?? '' }}</p>
                                                <hr>
                                                <h6>Order Summary</h6>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Subtotal:</span>
                                                    <span>₹{{ number_format($order->subtotal, 2) }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Tax ({{ $order->tax_rate }}%):</span>
                                                    <span>₹{{ number_format($order->tax_amount, 2) }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between fw-bold">
                                                    <span>Total:</span>
                                                    <span>₹{{ number_format($order->total_amount, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-shopping-bag fa-3x text-muted"></i>
                </div>
                <h4>No orders yet</h4>
                <p class="text-muted mb-4">You haven't placed any orders yet.</p>
                <a href="{{ route('home') }}" class="btn btn-primary px-4">
                    <i class="fas fa-utensils me-2"></i>Browse Menu
                </a>
            </div>
        @endif

    </section>
@endsection

@section('custom-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle order details
            document.querySelectorAll('.view-details').forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-order-id');
                    const detailsElement = document.getElementById(`order-details-${orderId}`);

                    // Toggle the display of the details
                    detailsElement.classList.toggle('d-none');

                    // Toggle the button icon
                    const icon = this.querySelector('i');
                    if (detailsElement.classList.contains('d-none')) {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else {
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                });
            });
        });

        // Order filtering and search functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Filter orders by status
            document.querySelectorAll('[data-filter]').forEach(filter => {
                filter.addEventListener('click', function(e) {
                    e.preventDefault();
                    const status = this.getAttribute('data-filter');
                    const orderItems = document.querySelectorAll('.order-item');

                    orderItems.forEach(item => {
                        if (status === 'all' || item.getAttribute('data-status') ===
                            status) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    // Update active filter button
                    document.querySelectorAll('[data-filter]').forEach(btn => {
                        btn.classList.remove('active');
                    });
                    this.classList.add('active');
                });
            });
        });
    </script>
@endsection
