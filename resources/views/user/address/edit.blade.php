@extends('layouts.user')

@section('title', 'Edit Address')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Edit Address</h3>
                </div>
                <div class="card-body">
                    <form id="addressForm" action="{{ route('user.address.store') }}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="address_id" value="{{ $address->id }}">
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="address_line_1" class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address_line_1" name="address_line_1" value="{{ old('address_line_1', $address->address_line_1) }}" placeholder="House No, Building, Street">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="address_line_2" class="form-label">Address Line 2</label>
                                <input type="text" class="form-control" id="address_line_2" name="address_line_2" value="{{ old('address_line_2', $address->address_line_2) }}" placeholder="Apartment, Area, Landmark (Optional)">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $address->city) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $address->state) }}">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $address->country) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="pincode" name="pincode" value="{{ old('pincode', $address->pincode) }}">
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $address->phone_number) }}">
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.address.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Addresses
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Address
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $("#addressForm").validate({
        rules: {
            address_line_1: {
                required: true,
                maxlength: 225
            },
            address_line_2: {
                maxlength: 225
            },
            city: {
                required: true
            },
            state: {
                required: true
            },
            country: {
                required: true
            },
            pincode: {
                required: true,
                minlength: 6
            },
            phone_number: {
                required: true,
                minlength: 10
            }
        },
        messages: {
            address_line_1: {
                required: "Please enter your address",
                maxlength: "Address line 1 cannot exceed 225 characters"
            },
            address_line_2: {
                maxlength: "Address line 2 cannot exceed 225 characters"
            },
            city: {
                required: "Please enter your city"
            },
            state: {
                required: "Please enter your state"
            },
            country: {
                required: "Please enter your country"
            },
            pincode: {
                required: "Please enter your pincode",
                minlength: "Pincode must be at least 6 characters long"
            },
            phone_number: {
                required: "Please enter your phone number",
                minlength: "Phone number must be at least 10 digits long"
            }
        },
        errorElement: "div",
        errorClass: "text-danger small",
        highlight: function(element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid");
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });
});
</script>
@endpush