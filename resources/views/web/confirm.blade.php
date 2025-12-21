@extends('web.web-layout')

@section('header')
    <!-- SPECIFIC CSS -->
    <link href="{{ asset('assets/web/css/order-sign_up.css') }}" rel="stylesheet">
@endsection

@section('main')
    <div class="container margin_60_20 mt-6">
        <div class="row justify-content-center bg-info rounded border" style="--bs-bg-opacity: .2;">
            <div class="col-lg-8">
                <div class="main text-center">
                    @if (request('order'))
                        <div class="success-icon mb-2 mt-4">
                            <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h3 class="text-success mb-3">Order Placed!</h3>

                        <div class="mb-4">
                            <p class="mb-2"><strong>Order ID:</strong> {{ request('order') }}</p>
                            <p class="mb-2"><strong>Order Date:</strong> {{ now()->format('M d, Y H:i') }}</p>
                            <p class="mb-2"><strong>Payment Method:</strong>
                                @if (request('payment') === 'cod')
                                    <span class="badge bg-warning">Cash on Delivery</span>
                                @else
                                    <span class="badge bg-success">Online Payment</span>
                                @endif
                            </p>
                        </div>

                        <div class="action-buttons mt-4">
                            <a href="{{ route('home') }}" class="text-primary text-decoration-underline">Continue
                                Shopping</a>
                            <p class="text-muted mt-3">Need help? Call us at <strong>0432 48432854</strong></p>
                        </div>
                    @else
                        <div class="error-icon mb-4">
                            <i class="fas fa-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="text-warning mb-3">Order Information Not Found</h4>
                        <p class="mb-4">We couldn't find the order information. Please contact us if you need assistance.
                        </p>

                        <div class="action-buttons mt-4">
                            <a href="{{ route('home') }}" class="btn btn-primary">Go to Home</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
@endsection
