@extends('layouts.user')

@section('content')
<div class="container py-4">
    <h1 class="h2 mb-4 text-center">Your Shopping Cart</h1>

    @if($cartItems->isEmpty())
        <div class="text-center py-5">
            <h3 class="h5 text-muted mb-4">Your cart is empty</h3>
            <a href="{{ route('user.shop') }}" class="btn btn-primary">Start Shopping</a>
        </div>
    @else
        <div class="row">
            <div class="col-lg-8">
                @foreach($cartItems as $item)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <img src="{{ asset('storage/' . $item->image) }}" 
                                     alt="{{ $item->name }}" 
                                     class="img-fluid rounded">
                            </div>
                            <div class="col-md-4">
                                <h5 class="card-title mb-1">{{ $item->name }}</h5>
                                <p class="card-text text-muted">${{ number_format($item->price, 2) }}</p>
                            </div>
                            <div class="col-md-4">
                                <form action="{{ route('user.cart.update') }}" 
                                      method="POST" 
                                      class="d-flex align-items-center">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="cart_id" value="{{ $item->id }}">
                                    <input type="number" 
                                           min="1" 
                                           value="{{ $item->quantity }}" 
                                           name="p_qty" 
                                           class="form-control me-2" 
                                           style="width: 80px;">
                                    <button type="submit" class="btn btn-outline-primary btn-sm">
                                        Update
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-2 text-end">
                                <div class="mb-2">${{ number_format($item->price * $item->quantity, 2) }}</div>
                                <a href="{{ route('user.cart.delete', $item->id) }}" 
                                   class="text-danger" 
                                   onclick="return confirm('Delete this item?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Order Summary</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Grand Total:</span>
                            <strong>${{ number_format($grandTotal, 2) }}</strong>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('user.checkout') }}" class="btn btn-primary">
                                Proceed to Checkout
                            </a>
                            <a href="{{ route('user.shop') }}" class="btn btn-outline-primary">
                                Continue Shopping
                            </a>
                            <a href="{{ route('user.cart.deleteAll') }}" 
                               class="btn btn-outline-danger"
                               onclick="return confirm('Delete all items from cart?');">
                                Clear Cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
</section>
@endsection