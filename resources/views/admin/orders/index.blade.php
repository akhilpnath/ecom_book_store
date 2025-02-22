@extends('layouts.admin')

@section('content')
<section class="placed-orders">
    <h1 class="title">Placed Orders</h1>
    <div class="box-container">
        @forelse($orders as $order)
        <div class="box">
            <p>User ID: <span>{{ $order->user_id }}</span></p>
            <p>Placed On: <span>{{ $order->placed_on }}</span></p>
            <p>Name: <span>{{ $order->name }}</span></p>
            <p>Email: <span>{{ $order->email }}</span></p>
            <p>Number: <span>{{ $order->number }}</span></p>
            <p>Address: <span>{{ $order->address }}</span></p>
            <p>Total Products: <span>{{ $order->total_products }}</span></p>
            <p>Total Price: <span>${{ $order->total_price }}/-</span></p>
            <p>Payment Method: <span>{{ $order->method }}</span></p>

            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <select name="payment_status" class="drop-down">
                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ $order->payment_status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                <div class="flex-btn">
                    <button type="submit" class="option-btn">Update</button>
                    
                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Delete this order?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </div>
            </form>
        </div>
        @empty
        <p class="empty">No orders placed yet!</p> 
        @endforelse
    </div>
</section>
@endsection
