@extends('layouts.user')

@section('title', 'All Products - BookStore')

@section('content')
<div class="bg-light py-5">
    <div class="container">
        <!-- Page Header -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <h1 class="display-6 fw-bold mb-3">All Products</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search products...">
                    <button class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <select class="form-select">
                                    <option selected>Category</option>
                                    <option>Novel</option>
                                    <option>Programs</option>
                                    <option>Stories</option>
                                    <option>Poetry</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select">
                                    <option selected>Sort By</option>
                                    <option>Price: Low to High</option>
                                    <option>Price: High to Low</option>
                                    <option>Newest First</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select">
                                    <option selected>Price Range</option>
                                    <option>Under $25</option>
                                    <option>$25 - $50</option>
                                    <option>Over $50</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-filter me-2"></i>Apply Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card h-100 product-card">
                        <!-- Product Image -->
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top p-3"
                                alt="{{ $product->name }}">
                            <div class="position-absolute top-0 end-0 p-3">
                                <span class="badge bg-primary fs-6">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                            </div>
                            <div class="position-absolute top-0 start-0 p-3">
                                <a href="{{ route('user.product.view', $product->id) }}"
                                    class="btn btn-light rounded-circle shadow-sm" title="Quick View">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="card-body">
                            <h5 class="card-title mb-3">{{ $product->name }}</h5>

                            <form action="{{ route('user.cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="d-flex gap-2 align-items-center mb-3">
                                    <div class="input-group" style="width: 120px;">
                                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                            onclick="decrementQty(this)">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" name="p_qty" value="1" min="1"
                                            class="form-control form-control-sm text-center">
                                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                            onclick="incrementQty(this)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="addToWishlist({{ $product->id }})">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>

                                <button type="submit" class="btn btn-primary w-100" name="add_to_cart">
                                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-books fa-3x mb-3 text-muted"></i>
                    <h4>No Products Found</h4>
                    <p class="text-muted">Try adjusting your search or filter criteria</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function incrementQty(button) {
            const input = button.previousElementSibling;
            input.value = parseInt(input.value) + 1;
        }

        function decrementQty(button) {
            const input = button.nextElementSibling;
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        function addToWishlist(productId) {
            // Add your wishlist functionality here
            alert('Added to wishlist!');
        }
    </script>
@endpush