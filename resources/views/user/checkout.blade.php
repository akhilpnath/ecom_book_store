@extends('layouts.user')

@section('content')
<div class="container py-4 mt-5">
    <h1 class="h2 mb-4 text-center">Checkout</h1>

    <form action="{{ route('user.checkout') }}" method="POST" id="checkoutForm">
        @csrf

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Billing Details</h5>

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="number" class="form-label">Phone Number</label>
                            <input type="text" name="number" id="number" class="form-control @error('number') is-invalid @enderror" value="{{ old('number') }}">
                            @error('number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <h5>Shipping Address</h5>
                            
                            @if($addresses->count() > 0)
                                <div class="mb-3">
                                    <select name="address_id" id="address_id" class="form-select @error('address_id') is-invalid @enderror">
                                        <option value="">Select an address</option>
                                        @foreach($addresses as $address)
                                            <option value="{{ $address->id }}" {{ old('address_id') == $address->id ? 'selected' : '' }}>
                                                {{ $address->address_line_1 }}, {{ $address->city }}, {{ $address->state }}, {{ $address->country }} - {{ $address->pincode }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('address_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <a href="{{ route('user.address.create') }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-plus"></i> Add New Address
                                        </a>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="use_manual_address" name="use_manual_address">
                                        <label class="form-check-label" for="use_manual_address">
                                            Enter different address
                                        </label>
                                    </div>
                                </div>
                            @endif

                            <div id="manual_address_fields" class="{{ $addresses->count() > 0 ? 'd-none' : '' }}">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Shipping Address</label>
                                    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="method" class="form-label">Payment Method</label>
                            <select name="method" id="method" class="form-select @error('method') is-invalid @enderror">
                                <option value="credit_card" {{ old('method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="paypal" {{ old('method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                <option value="cash_on_delivery" {{ old('method') == 'cash_on_delivery' ? 'selected' : '' }}>Cash on Delivery</option>
                            </select>
                            @error('method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Order Summary</h5>

                        <div class="d-flex justify-content-between">
                            <span>Total Price:</span>
                            <strong>${{ number_format($grandTotal, 2) }}</strong>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-success w-100 mt-3">
                            Place Order
                        </button>

                        <a href="{{ route('user.cart') }}" class="btn btn-outline-secondary w-100 mt-2">
                            Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        
        $("#use_manual_address").change(function() {
            if($(this).is(":checked")) {
                $("#manual_address_fields").removeClass("d-none");
                $("#address_id").prop("disabled", true);
            } else {
                $("#manual_address_fields").addClass("d-none");
                $("#address_id").prop("disabled", false);
            }
        });
        
        // Form validation
        $("#checkoutForm").validate({
            errorClass: "is-invalid",
            validClass: "is-valid",
            errorElement: "div",
            errorPlacement: function (error, element) {
                error.addClass("invalid-feedback");
                element.closest(".mb-3").append(error);
            },
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true
                },
                number: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 15
                },
                address: {
                    required: function() {
                        return $("#use_manual_address").is(":checked") || $("select[name='address_id']").length === 0;
                    },
                    minlength: 5
                },
                address_id: {
                    required: function() {
                        return !$("#use_manual_address").is(":checked") && $("select[name='address_id']").length > 0;
                    }
                },
                method: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Please enter your full name",
                    minlength: "Name must be at least 3 characters"
                },
                email: {
                    required: "Please enter your email",
                    email: "Enter a valid email address"
                },
                number: {
                    required: "Please enter your phone number",
                    digits: "Only numbers are allowed",
                    minlength: "Phone number must be at least 10 digits",
                    maxlength: "Phone number cannot exceed 15 digits"
                },
                address: {
                    required: "Please enter your shipping address",
                    minlength: "Address must be at least 5 characters"
                },
                address_id: {
                    required: "Please select an address or enter a new one"
                },
                method: {
                    required: "Please select a payment method"
                }
            }
        });
    });
</script>
@endpush