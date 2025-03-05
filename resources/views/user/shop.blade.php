@extends('layouts.user')

@section('title', 'All Products - BookStore')

@section('content')
<div class="bg-light py-5 mt-4">
    <div class="container">
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
                <form action="{{ route('user.shop') }}" method="GET" id="searchForm">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search products..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('user.shop') }}" method="GET" id="filterForm">
                            @if(request()->has('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif

                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <select class="form-select filter-select" name="category">
                                        <option value="">Select category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select filter-select" name="sort_by">
                                        <option value="">Sort By</option>
                                        <option value="Price: Low to High" {{ request('sort_by') == 'Price: Low to High' ? 'selected' : '' }}>
                                            Price: Low to High
                                        </option>
                                        <option value="Price: High to Low" {{ request('sort_by') == 'Price: High to Low' ? 'selected' : '' }}>
                                            Price: High to Low
                                        </option>
                                        <option value="Newest First" {{ request('sort_by') == 'Newest First' ? 'selected' : '' }}>
                                            Newest First
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select filter-select" name="price_range">
                                        <option value="">Price Range</option>
                                        <option value="Under $25" {{ request('price_range') == 'Under $25' ? 'selected' : '' }}>
                                            Under $25
                                        </option>
                                        <option value="$25 - $50" {{ request('price_range') == '$25 - $50' ? 'selected' : '' }}>
                                            $25 - $50
                                        </option>
                                        <option value="Over $50" {{ request('price_range') == 'Over $50' ? 'selected' : '' }}>
                                            Over $50
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-filter me-2"></i>Apply Filters
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card h-100 product-card d-flex flex-column">
                        <div class="position-relative">
                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}"
                                class="card-img-top p-3" alt="{{ $product->name }}"
                                style="height: 200px; object-fit: contain;">

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

                        <div class="card-body d-flex flex-column flex-grow-1">
                            <h5 class="card-title mb-3 text-truncate" style="max-width: 100%;" data-bs-toggle="tooltip"
                                title="{{ $product->name }}">
                                {{ $product->name }}
                            </h5>

                            <form action="{{ route('user.cart.add') }}" method="POST" class="mt-auto">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="d-flex gap-2 align-items-center mb-3">
                                    <div class="input-group quantity-container" style="width: 120px;">
                                        <button type="button" class="btn btn-outline-secondary btn-sm decrement-qty">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" name="p_qty" value="1" min="1"
                                            class="form-control form-control-sm text-center quantity-input">
                                        <button type="button" class="btn btn-outline-secondary btn-sm increment-qty">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                    <button type="button" class="btn btn-outline-danger btn-sm add-to-wishlist"
                                        data-id="{{ $product->id }}">
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
                    <i class="fas fa-box-open fa-3x mb-3 text-muted"></i>
                    <h4>No Products Found</h4>
                    <p class="text-muted">Try adjusting your search or filter criteria</p>
                </div>
            @endforelse
        </div>

        <div class="row mt-5">
            <div class="col-12">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(".add-to-wishlist").click(function () {
                let productId = $(this).data("id");

                $.ajax({
                    url: "{{ route('user.wishlist.add') }}",
                    type: "POST",
                    data: { product_id: productId },
                    success: function (response) {
                        alert("✅ " + response.success);
                    },
                    error: function (xhr) {
                        if (xhr.status === 409) {
                            alert("❌ Product already in wishlist!");
                        } else {
                            alert("❌ Error adding to wishlist. Try again!");
                        }
                    }
                });
            });

            $(".increment-qty").click(function () {
                console.log("Increment button clicked!");
                let input = $(this).closest(".quantity-container").find(".quantity-input");
                input.val(parseInt(input.val()) + 1).trigger("change");
            });

            $(".decrement-qty").click(function () {
                console.log("Decrement button clicked!");
                let input = $(this).closest(".quantity-container").find(".quantity-input");
                if (parseInt(input.val()) > 1) {
                    input.val(parseInt(input.val()) - 1).trigger("change");
                }
            });

            $(".filter-select").change(function () {
                console.log("Filter select changed!");
                $("#filterForm").submit();
            });

            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>

@endpush