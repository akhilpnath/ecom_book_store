@extends('layouts.user')

@section('content')
    <div class="home-section text-left">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4" style="color: black;">Discover Your Next Great Read</h1>
                    <p class="lead mb-4" style="color: black;">Explore thousands of books at your fingertips</p>
                    <a href="#categories" class="btn btn-primary btn-lg px-5">
                        Start Exploring
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section id="categories" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold home-page-section-text">
                Shop by Category
                <span style="display: block; width: 100px; height: 4px; background: #0d6efd; margin: 8px auto 0;"></span>
            </h2>

            @if($categories->count())
                <div class="category-slider">
                    <div class="category-track">
                        @foreach($categories as $category)
                            <div class="category-item">
                                <div class="card category-card h-100">
                                    <img src="{{ Str::startsWith($category['image'], 'http') ? $category['image'] : asset('storage/' . $category['image']) }}"
                                        class="card-img-top" alt="{{ $category['name'] }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $category['name'] }}</h5>
                                        <p class="card-text text-muted">{{ $category['desc'] }}</p>
                                        <a href="{{ route('user.category', $category['name']) }}" class="btn btn-outline-primary">
                                            Browse {{ $category['name'] }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- Duplicate items for smooth looping -->
                        @foreach($categories as $category)
                            <div class="category-item">
                                <div class="card category-card h-100">
                                    <img src="{{ Str::startsWith($category['image'], 'http') ? $category['image'] : asset('storage/' . $category['image']) }}"
                                        class="card-img-top" alt="{{ $category['name'] }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $category['name'] }}</h5>
                                        <p class="card-text text-muted">{{ $category['desc'] }}</p>
                                        <a href="{{ route('user.category', $category['name']) }}" class="btn btn-outline-primary">
                                            Browse {{ $category['name'] }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-center text-muted">No categories available.</p>
            @endif
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold home-page-section-text">
                Latest Products
                <span style="display: block; width: 100px; height: 4px; background: #0d6efd; margin: 8px auto 0;"></span>
            </h2>
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-md-6 col-lg-3">
                        <div class="card product-card h-100 d-flex flex-column">
                            <div class="position-relative">
                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}"
                                    class="card-img-top p-3" alt="{{ $product->name }}"
                                    style="height: 200px; object-fit: contain;">
                                <div class="position-absolute top-0 end-0 p-3">
                                    <span class="badge bg-primary">${{ number_format($product->price, 2) }}</span>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column flex-grow-1">
                                <h5 class="card-title text-truncate" style="max-width: 100%;" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </h5>
                                <form action="{{ route('user.cart.add') }}" method="POST" class="mt-auto">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <input type="number" min="1" value="1" name="p_qty" class="form-control"
                                            style="width: 100px;">
                                        <a href="{{ route('user.product.view', $product->id) }}"
                                            class="btn btn-outline-secondary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm add-to-wishlist-home"
                                            data-id="{{ $product->id }}">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100" name="add_to_cart">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(".add-to-wishlist-home").click(function () {
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
        });
    </script>
@endpush