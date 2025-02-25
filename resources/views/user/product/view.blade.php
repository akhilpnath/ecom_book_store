@extends('layouts.user')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.shop') }}">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Product Image Column -->
                        <div class="col-md-6">
                            <div class="position-relative">
                                <img 
                                    src="{{ asset('storage/' . $product->image) }}" 
                                    alt="{{ $product->name }}" 
                                    class="img-fluid rounded"
                                    id="mainProductImage"
                                >
                                @if($product->sale_price)
                                    <span class="position-absolute top-0 start-0 badge bg-danger m-3">
                                        SALE
                                    </span>
                                @endif
                            </div>

                            @if(isset($product->gallery) && count($product->gallery) > 0)
                            <div class="row g-2 mt-3">
                                @foreach($product->gallery as $image)
                                <div class="col-3">
                                    <img 
                                        src="{{ asset('storage/' . $image) }}" 
                                        alt="Product gallery image" 
                                        class="img-fluid rounded cursor-pointer thumbnail"
                                        onclick="updateMainImage(this.src)"
                                    >
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <!-- Product Details Column -->
                        <div class="col-md-6">
                            <h1 class="h2 mb-3">{{ $product->name }}</h1>
                            
                            <div class="mb-4">
                                @if($product->sale_price)
                                    <span class="h3 text-danger me-2">${{ number_format($product->sale_price, 2) }}</span>
                                    <span class="text-muted text-decoration-line-through">${{ number_format($product->price, 2) }}</span>
                                @else
                                    <span class="h3">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>

                            @if($product->stock > 0)
                                <div class="badge bg-success mb-3">In Stock</div>
                            @else
                                <div class="badge bg-danger mb-3">Out of Stock</div>
                            @endif

                            <div class="mb-4">
                                <h5 class="mb-3">Description</h5>
                                <p class="text-muted">{{ $product->details }}</p>
                            </div>

                            <form action="{{ route('user.cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <div class="mb-4">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <div class="input-group" style="width: 140px;">
                                        <button type="button" class="btn btn-outline-secondary" onclick="decrementQuantity()">-</button>
                                        <input 
                                            type="number" 
                                            class="form-control text-center" 
                                            id="quantity"
                                            name="p_qty" 
                                            value="1" 
                                            min="1" 
                                            max="{{ $product->stock }}"
                                        >
                                        <button type="button" class="btn btn-outline-secondary" onclick="incrementQuantity()">+</button>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button 
                                        type="submit" 
                                        name="add_to_cart" 
                                        class="btn btn-primary btn-lg"
                                        {{ $product->stock == 0 ? 'disabled' : '' }}
                                    >
                                        <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                    </button>
                                    <button type="button" class="btn btn-outline-primary">
                                        <i class="fas fa-heart me-2"></i>Add to Wishlist
                                    </button>
                                </div>
                            </form>

                            @if(isset($product->features) && count($product->features) > 0)
                            <div class="mt-4">
                                <h5 class="mb-3">Key Features</h5>
                                <ul class="list-unstyled">
                                    @foreach($product->features as $feature)
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>{{ $feature }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateMainImage(src) {
    document.getElementById('mainProductImage').src = src;
}

function incrementQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    const currentValue = parseInt(input.value);
    if (currentValue < max) {
        input.value = currentValue + 1;
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
    }
}
</script>
@endpush

@push('styles')
<style>
.thumbnail {
    transition: opacity 0.2s ease-in-out;
    cursor: pointer;
}

.thumbnail:hover {
    opacity: 0.8;
}

#mainProductImage {
    max-height: 500px;
    object-fit: contain;
}
</style>
@endpush
@endsection