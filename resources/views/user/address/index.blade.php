@extends('layouts.user')

@section('title', 'My Addresses')

@section('content')
<div class="container py-5 mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>My Addresses</h2>
                <a href="{{ route('user.address.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Address
                </a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @if($addresses->count() > 0)
                <div class="row">
                    @foreach($addresses as $address)
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        Address #{{ $loop->iteration }}
                                    </h5>
                                    <address class="mb-3">
                                        {{ $address->address_line_1 }}<br>
                                        @if($address->address_line_2)
                                            {{ $address->address_line_2 }}<br>
                                        @endif
                                        {{ $address->city }}, {{ $address->state }}<br>
                                        {{ $address->country }} - {{ $address->pincode }}<br>
                                        <i class="fas fa-phone-alt text-secondary me-1"></i> {{ $address->phone_number }}
                                    </address>
                                    
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('user.address.edit', $address->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('user.address.delete', $address->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                    <h4>No addresses found</h4>
                    <p>You haven't added any delivery addresses yet.</p>
                    <a href="{{ route('user.address.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus"></i> Add New Address
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {

        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this address?')) {
                this.submit();
            }
        });
    });
</script>
@endpush