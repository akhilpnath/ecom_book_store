@extends('layouts.user')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">{{ $category }}</h1>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Sort By
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Price: Low to High</a></li>
                    <li><a class="dropdown-item" href="#">Price: High to Low</a></li>
                    <li><a class="dropdown-item" href="#">Newest First</a></li>
                </ul>
            </div>
        </div>

        @if($products->isEmpty())
            <div class="alert alert-info">
                No products found in this category.
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                @foreach($products as $product)
                    <div class="col">
                        <div class="card h-100 shadow-sm product-card">
                            <div class="position-relative">
                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" style="padding-left: 3rem">
                                <a href="{{ route('user.product.view', $product->id) }}"
                                    class="btn btn-light btn-sm position-absolute top-0 end-0 m-2">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-primary fw-bold">
                                    ${{ number_format($product->price, 2) }}
                                </p>
                                <form action="{{ route('user.cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="d-flex gap-2 align-items-center mb-3">
                                        <input type="number" min="1" value="1" name="p_qty" class="form-control"
                                            style="width: 80px;">
                                    </div>
                                    <button type="submit" name="add_to_cart" class="btn btn-primary w-100">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">

            </div>
        @endif
    </div>
@endsection


<style>
    .product-card:hover {
        transform: translateY(-5px);
        transition: transform 0.2s ease-in-out;
    }

    .product-card .card-img-top {
        height: 200px;
        object-fit: cover;
    }
</style>