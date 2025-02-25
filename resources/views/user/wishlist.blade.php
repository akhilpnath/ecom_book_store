@extends('layouts.user')

@section('content')
    <div class="container my-5">
        <h1 class="text-center mb-4">Your Wishlist</h1>

        <div class="row g-4">
            @foreach($wishlistItems as $item)
                <div class="col-md-4 col-sm-6">
                    <div class="card shadow-sm">
                        <div class="position-relative">
                            <a href="{{ route('user.wishlist.delete', $item->id) }}"
                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"
                                onclick="return confirm('Delete this item?');">
                                <i class="fas fa-times"></i>
                            </a>
                            <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top img-fluid"
                                alt="{{ $item->name }}">
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text text-primary fw-bold">${{ $item->price }}/-</p>
                            <form action="{{ route('user.cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                <div class="input-group mb-3">
                                    <input type="number" min="1" value="1" name="p_qty" class="form-control text-center">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <h4>Grand Total: <span class="text-success fw-bold">${{ $grandTotal }}/-</span></h4>
            <a href="{{ route('user.shop') }}" class="btn btn-outline-primary me-2">Continue Shopping</a>
            <a href="{{ route('user.wishlist.deleteAll') }}" class="btn btn-outline-danger">Delete All</a>
        </div>
    </div>
@endsection