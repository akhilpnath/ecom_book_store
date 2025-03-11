@extends('layouts.admin')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Placed Orders</h1>

        <div class="row">
            @forelse($orders as $order)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Order #{{ $order->id }}</h5>
                            <p class="text-muted mb-1"><i class="fas fa-user"></i> User ID:
                                <strong>{{ $order->user_id }}</strong>
                            </p>
                            <p class="text-muted mb-1"><i class="fas fa-calendar-alt"></i> Placed On:
                                <strong>{{ $order->placed_on }}</strong>
                            </p>
                            <p class="text-muted mb-1"><i class="fas fa-user"></i> Name: <strong>{{ $order->name }}</strong></p>
                            <p class="text-muted mb-1"><i class="fas fa-envelope"></i> Email:
                                <strong>{{ $order->email }}</strong>
                            </p>
                            <p class="text-muted mb-1"><i class="fas fa-phone"></i> Number:
                                <strong>{{ $order->number }}</strong>
                            </p>
                            <p class="text-muted mb-1"><i class="fas fa-map-marker-alt"></i> Address:
                                <strong>{{ $order->address }}</strong>
                            </p>
                            <p class="text-muted mb-1"><i class="fas fa-box"></i> Total Products:
                                <strong>{{ $order->total_products }}</strong>
                            </p>
                            <p class="text-muted mb-1"><i class="fas fa-dollar-sign"></i> Total Price:
                                <strong>${{ $order->total_price }}/-</strong>
                            </p>
                            <p class="text-muted mb-1"><i class="fas fa-credit-card"></i> Payment Method:
                                <strong>{{ $order->method }}</strong>
                            </p>

                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="mt-3">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="payment_status_{{ $order->id }}" class="form-label">Payment Status</label>
                                    <select name="payment_status" id="payment_status_{{ $order->id }}" class="form-select">
                                        <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="completed" {{ $order->payment_status == 'completed' ? 'selected' : '' }}>
                                            Completed</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-sync"></i> Update</button>
                            </form>

                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="mt-2"
                                onsubmit="return confirm('Are you sure you want to delete this order?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-circle"></i> No orders placed yet!
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = false;

        var pusher = new Pusher('b8050f826c0df4cdd3bd', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('OrderConfirmation');
        channel.bind('NewOrderConfirmation', function (data) {
            // Create HTML for the new order card
            var orderHtml = `
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Order #${data.order.id}</h5>
                    <p class="text-muted mb-1"><i class="fas fa-user"></i> User ID:
                        <strong>${data.order.user_id}</strong>
                    </p>
                    <p class="text-muted mb-1"><i class="fas fa-calendar-alt"></i> Placed On:
                        <strong>${data.order.placed_on}</strong>
                    </p>
                    <p class="text-muted mb-1"><i class="fas fa-user"></i> Name: <strong>${data.order.name}</strong></p>
                    <p class="text-muted mb-1"><i class="fas fa-envelope"></i> Email:
                        <strong>${data.order.email}</strong>
                    </p>
                    <p class="text-muted mb-1"><i class="fas fa-phone"></i> Number:
                        <strong>${data.order.number}</strong>
                    </p>
                    <p class="text-muted mb-1"><i class="fas fa-map-marker-alt"></i> Address:
                        <strong>${data.order.address}</strong>
                    </p>
                    <p class="text-muted mb-1"><i class="fas fa-box"></i> Total Products:
                        <strong>${data.order.total_products}</strong>
                    </p>
                    <p class="text-muted mb-1"><i class="fas fa-dollar-sign"></i> Total Price:
                        <strong>$${data.order.total_price}/-</strong>
                    </p>
                    <p class="text-muted mb-1"><i class="fas fa-credit-card"></i> Payment Method:
                        <strong>${data.order.method}</strong>
                    </p>

                    <form action="/admin/orders/${data.order.id}" method="POST" class="mt-3">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="payment_status_${data.order.id}" class="form-label">Payment Status</label>
                            <select name="payment_status" id="payment_status_${data.order.id}" class="form-select">
                                <option value="pending" ${data.order.payment_status == 'pending' ? 'selected' : ''}>
                                    Pending</option>
                                <option value="completed" ${data.order.payment_status == 'completed' ? 'selected' : ''}>
                                    Completed</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-sync"></i> Update</button>
                    </form>

                    <form action="/admin/orders/${data.order.id}" method="POST" class="mt-2"
                        onsubmit="return confirm('Are you sure you want to delete this order?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100"><i class="fas fa-trash"></i> Delete</button>
                    </form>
                </div>
            </div>
        </div>`;

            // Find the orders container
            var ordersContainer = $('.row');

            // Check if "No orders" alert exists and remove it if it does
            if (ordersContainer.find('.alert-warning').length) {
                ordersContainer.empty();
            }

            // Prepend the new order to the container
            ordersContainer.prepend(orderHtml);
        });
    });
</script>