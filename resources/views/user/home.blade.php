@extends('layouts.user')

@section('content')
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Discover Your Next Great Read</h1>
            <p class="lead mb-4">Explore thousands of books at your fingertips</p>
            <a href="#categories" class="btn btn-primary btn-lg px-5">
                Start Exploring
            </a>
        </div>
    </div>

    <section id="categories" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Shop by Category</h2>
            <div class="row g-4">
                @php
                    $categories = [
                        ['name' => 'Programs', 'image' => 'Program.jpg', 'desc' => 'Python for Data Analysis, Learning PHP, Scala the Impatient, Eloquent JavaScript.'],
                        ['name' => 'Stories', 'image' => 'stories.jpg', 'desc' => 'Dubliners, The Illustrated Man, The Things They Carried, Interpreter of Maladies.'],
                        ['name' => 'Novel', 'image' => 'novel.jpeg', 'desc' => 'Animal Farm, Brave New World, The Catcher in the Rye, To Kill a Mockingbird.'],
                        ['name' => 'Poetry', 'image' => 'poetry.jpg', 'desc' => 'Milk and Honey, Ariel, Selected Poems, The Sun and Her Flowers.']
                    ];
                @endphp

                @foreach($categories as $category)
                    <div class="col-md-6 col-lg-3">
                        <div class="card category-card h-100">
                            <img src="{{ asset('images/' . $category['image']) }}" class="card-img-top"
                                alt="{{ $category['name'] }}">
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
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Latest Products</h2>
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-md-6 col-lg-3">
                        <div class="card product-card h-100">
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                    alt="{{ $product->name }}">
                                <div class="position-absolute top-0 end-0 p-3">
                                    <span class="badge bg-primary">${{ number_format($product->price, 2) }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <form action="{{ route('user.cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <input type="number" min="1" value="1" name="p_qty" class="form-control"
                                            style="width: 100px;">
                                        <a href="{{ route('user.product.view', $product->id) }}"
                                            class="btn btn-outline-secondary">
                                            <i class="fas fa-eye"></i>
                                        </a>
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