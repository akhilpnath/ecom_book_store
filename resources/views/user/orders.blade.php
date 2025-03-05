@extends('layouts.user')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 fw-bold">Your Orders</h2>
            
            @if($orders->isEmpty())
                <div class="alert alert-info" role="alert">
                    You haven't placed any orders yet.
                </div>
            @else
                <div class="row">
                    @foreach($orders as $order)
                    <div class="col-12 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <span>Order #{{ $order->id }}</span>
                                <span>Placed On: {{ $order->placed_on }}</span>
                            </div>
                            
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <h5 class="card-title">Customer Details</h5>
                                        <ul class="list-unstyled">
                                            <li><strong>Name:</strong> {{ $order->name }}</li>
                                            <li><strong>Email:</strong> {{ $order->email }}</li>
                                            <li><strong>Address:</strong> {{ $order->address }}</li>
                                        </ul>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <h5 class="card-title">Order Details</h5>
                                        <ul class="list-unstyled">
                                            <li><strong>Payment Method:</strong> {{ $order->method }}</li>
                                            <li><strong>Total Products:</strong> {{ $order->total_products }}</li>
                                            <li><strong>Total Price:</strong> ${{ number_format($order->total_price, 2) }}</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <span class="badge {{ $order->payment_status === 'completed' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection