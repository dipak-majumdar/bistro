@extends('layouts.web.user-portal.main-layout')

@push('styles')
@endpush

@section('main')
    <style>
        .address-card {
            transition: all 0.3s ease-in-out;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid transparent;
            position: relative;
        }

        .address-card::before {
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
        .address-card>* {
            position: relative;
            z-index: 1;
        }

        .address-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1.5rem rgba(13, 110, 253, 0.1) !important;
        }

        .address-card:hover::before {
            opacity: 1;
        }
    </style>
    <section class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">{{ __('Address Book') }}</h4>

            <a class="btn btn-sm btn-outline-primary rounded" href="{{ route('profile.address-book.create') }}">Add New Address</a>
        </div>

        @if (isset($addressBooks) && count($addressBooks) > 0)
            <div class="row g-4" id="addressContainer">
                @foreach ($addressBooks as $address)
                    @php
                        $addressData = json_decode($address->address, true);
                    @endphp
                    <div class="col-12 address-item">
                        <div class="card address-card border-0 shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="mb-1">{{ $addressData['name'] ?? 'N/A' }}</h6>
                                        <small class="text-muted">{{ $addressData['mobile'] ?? 'N/A' }}</small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        @if ($address->is_default == 1)
                                            <span class="badge rounded-pill bg-primary">Primary</span>
                                        @endif
                                        <span
                                            class="badge rounded-pill bg-secondary">{{ ucfirst($addressData['address_type'] ?? 'home') }}</span>
                                    </div>
                                </div>

                                <div class="address-details">
                                    <p class="mb-2">
                                        <strong>Address:</strong><br>
                                        {{ $addressData['address'] ?? 'N/A' }}
                                        @if (!empty($addressData['address_2']))
                                            <br>{{ $addressData['address_2'] }}
                                        @endif
                                    </p>
                                    <p class="mb-2">
                                        @if (!empty($addressData['landmark']))
                                            <strong>Landmark:</strong> {{ $addressData['landmark'] }}<br>
                                        @endif
                                        <strong>City:</strong> {{ $addressData['city'] ?? 'N/A' }},
                                        <strong>Pincode:</strong> {{ $addressData['pincode'] ?? 'N/A' }}
                                    </p>
                                </div>

                                <div class="d-flex gap-2 mt-3">
                                    <a href="{{ route('profile.address-book.edit', $address->id) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <button class="btn btn-outline-danger btn-sm"
                                        onclick="deleteAddress({{ $address->id }})">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-map-marker-alt fa-3x text-muted"></i>
                </div>
                <h4>No addresses yet</h4>
                <p class="text-muted mb-4">You haven't added any addresses yet.</p>
                <a href="{{ route('profile.address-book.create') }}" class="btn btn-primary px-4">
                    <i class="fas fa-plus me-2"></i>Add Your First Address
                </a>
            </div>
        @endif

    </section>
@endsection

@section('custom-js')
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

        function deleteAddress(addressId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    // Add CSRF token
                    // const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(`/address-book/delete/${addressId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Remove the address card from DOM
                                const addressElement = document.querySelector(
                                    `[onclick="deleteAddress(${addressId})"]`).closest('.address-item');
                                addressElement.remove();

                                // Show success message
                                window.showToast(data.message || 'Address deleted successfully!', {
                                    variant: 'success',
                                    delay: 4000
                                });

                                // Check if no addresses left and show empty state
                                const remainingAddresses = document.querySelectorAll('.address-item');
                                if (remainingAddresses.length === 0) {
                                    location.reload();
                                }
                            } else {
                                window.showToast(data.message || 'Failed to delete address', {
                                    variant: 'danger',
                                    delay: 4000
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            window.showToast('An error occurred while deleting the address', {
                                variant: 'danger',
                                delay: 4000
                            });
                        });
                }
            });
        }
    </script>
@endsection
