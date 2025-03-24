@extends('layouts.user')

@section('content')
    <div class="container my-5 pt-4">
        <h1 class="text-center mb-4">Your Wishlist</h1>

        @if ($wishlistItems->isEmpty())
            <div class="text-center py-5">
                <h3 class="h5 text-muted mb-4">Oops! Your wishlist is empty 😔</h3>
                <p class="text-muted">Start adding your favorite products to the wishlist now!</p>
                <a href="{{ route('user.shop') }}" class="btn btn-primary">Start Shopping</a>
            </div>
        @else
            <div class="row justify-content-center g-4">
                @foreach ($wishlistItems as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card shadow-sm h-100">
                            <div class="position-relative">
                                {{-- Delete button --}}
                                <form action="{{ route('user.wishlist.delete', $item->id) }}" method="POST"
                                    class="position-absolute top-0 end-0 m-2"
                                    onsubmit="return confirm('Delete this item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>

                                {{-- Product Image with Fallback --}}
                                <img src="{{ $item->image ? (Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image)) : asset('images/placeholder.png') }}"
                                    class="card-img-top img-fluid p-3" alt="{{ $item->name }}"
                                    style="height: 200px; object-fit: contain;">
                            </div>

                            <div class="card-body text-center d-flex flex-column">
                                {{-- Product Name --}}
                                <h5 class="card-title text-truncate" style="max-width: 100%;" title="{{ $item->name }}">
                                    {{ $item->name }}
                                </h5>
                                {{-- Product Price --}}
                                <p class="card-text text-primary fw-bold">${{ number_format($item->price, 2) }}</p>

                                {{-- Check if Product Exists --}}
                                @php
                                    $product = \App\Models\Product::find($item->product_id);
                                @endphp

                                @if ($product)
                                    <form action="{{ route('user.cart.add') }}" method="POST" class="mt-auto">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                        <div class="input-group mb-3">
                                            <input type="number" min="1" value="1" name="p_qty"
                                                class="form-control text-center quantity-input">
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary w-100" disabled>Product Unavailable</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                {{-- Grand Total --}}
                <h4>Grand Total: <span class="text-success fw-bold">${{ number_format($grandTotal, 2) }}</span></h4>
                <a href="{{ route('user.shop') }}" class="btn btn-outline-primary me-2">Continue Shopping</a>

                {{-- Delete All --}}
                <form action="{{ route('user.wishlist.deleteAll') }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete all items?');" class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Delete All</button>
                </form>
            </div>
        @endif
    </div>
@endsection
