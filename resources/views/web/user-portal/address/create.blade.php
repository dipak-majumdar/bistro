@extends('layouts.web.user-portal.main-layout')

@push('styles')
@endpush

@section('main')
    <section class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-4">{{ isset($address) ? 'Edit Address' : 'Add New Address' }}</h4>
        </div>
        <div class="row g-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ isset($address) ? route('profile.address-book.update', $address->id) : route('profile.address-book.store') }}" class="needs-validation" novalidate>
                            @csrf
                            @if(isset($address))
                                @method('PUT')
                            @endif
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $addressData['name'] ?? old('name') }}" required>
                                    <div class="invalid-feedback">
                                        Please provide your name.
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="mobile" class="form-label">Mobile *</label>
                                    <input type="tel" class="form-control" id="mobile" name="mobile" value="{{ $addressData['mobile'] ?? old('mobile') }}" pattern="[6-9][0-9]{9}" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid 10-digit mobile number.
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="address_type" class="form-label">Address Type *</label>
                                    <select class="form-control" id="address_type" name="address_type" required>
                                        <option value="">Select Address Type</option>
                                        <option value="home" {{ (isset($addressData) && $addressData['address_type'] == 'home') ? 'selected' : '' }}>Home</option>
                                        <option value="work" {{ (isset($addressData) && $addressData['address_type'] == 'work') ? 'selected' : '' }}>Work</option>
                                        <option value="other" {{ (isset($addressData) && $addressData['address_type'] == 'other') ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select an address type.
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <label for="address" class="form-label">Address *</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required>{{ $addressData['address'] ?? old('address') }}</textarea>
                                    <div class="invalid-feedback">
                                        Please provide your address.
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <label for="address_2" class="form-label">Address Line 2</label>
                                    <input type="text" class="form-control" id="address_2" name="address_2" value="{{ $addressData['address_2'] ?? old('address_2') }}">
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="city" class="form-label">City *</label>
                                    <input type="text" class="form-control" id="city" name="city" value="{{ $addressData['city'] ?? old('city') }}" required>
                                    <div class="invalid-feedback">
                                        Please provide your city.
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="pincode" class="form-label">Pincode *</label>
                                    <input type="text" class="form-control" id="pincode" name="pincode" value="{{ $addressData['pincode'] ?? old('pincode') }}" pattern="[0-9]{6}" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid 6-digit pincode.
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <label for="landmark" class="form-label">Landmark</label>
                                    <input type="text" class="form-control" id="landmark" name="landmark" value="{{ $addressData['landmark'] ?? old('landmark') }}" required>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1" {{ (isset($address) && $address->is_default == 1) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_default">
                                            Set as default address
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('profile.address-book') }}" class="btn btn-sm btn-secondary">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i>
                                            Cancel
                                        </a>

                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="bi bi-floppy2 me-1"></i>
                                            {{ isset($address) ? 'Update Address' : 'Save Address' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom-js')
<script>
// Bootstrap form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>
@endsection
