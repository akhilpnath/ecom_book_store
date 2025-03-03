@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Add New Product</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.books.search') }}" class="btn btn-outline-primary ms-auto">
                                <i class="fas fa-globe"></i> External API Add
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" name="name" class="form-control" required
                                            placeholder="Enter product name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Product Author</label>
                                        <input type="text" name="authors" class="form-control" required
                                            placeholder="Enter product author name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Category</label>
                                        <select name="category" class="form-select" required>
                                            <option value="" selected disabled>Select category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category }}">{{ $category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Language</label>
                                        <input type="text" name="language" class="form-control" required
                                            placeholder="Enter product language">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Price ($)</label>
                                        <input type="number" min="0" name="price" class="form-control" required
                                            placeholder="Enter product price">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Product Image</label>
                                        <input type="file" name="image" required class="form-control"
                                            accept="image/jpg, image/jpeg, image/png">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Product Details</label>
                                        <textarea name="details" class="form-control" required
                                            placeholder="Enter product details" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add Product
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Products List</h5>
                        <div class="d-flex gap-2">
                            <input type="text" id="productSearch" class="form-control" placeholder="Search Product..."
                                style="width: 250px;">
                            <button class="btn btn-outline-primary" id="toggleViewBtn">
                                <i class="fas fa-table"></i> Table View
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4" id="cardView">
                            @foreach($products as $product)
                                <div class="col-xl-3 col-lg-4 col-md-6 product-card">
                                    <div class="card h-100 shadow-sm">
                                        <div class="position-relative">
                                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}"
                                                class="card-img-top p-3" alt="{{ $product->name }}"
                                                style="height: 200px; object-fit: contain;">
                                            <div class="position-absolute top-0 end-0 p-3">
                                                <span class="badge bg-primary">${{ $product->price }}</span>
                                            </div>
                                        </div>
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-truncate">{{ $product->name }}</h5>
                                            <p class="badge bg-secondary mb-2"
                                                style="max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                {{ $product->category }}
                                            <p class="card-text small text-muted" style="height: 3em; overflow: hidden;">
                                                {{ $product->details }}
                                            </p>
                                        </div>
                                        <div class="card-footer bg-white border-top-0 d-flex gap-2">
                                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                                class="btn btn-outline-primary btn-sm flex-grow-1">
                                                <i class="fas fa-edit me-1"></i>Edit
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                                class="flex-grow-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                                                    onclick="return confirm('Delete this product?')">
                                                    <i class="fas fa-trash-alt me-1"></i>Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="table-responsive" id="tableView" style="display: none;">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Price ($)</th>
                                        <th>Category</th>
                                        <th>Details</th>
                                        <th>Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr class="product-row">
                                            <td>{{ $product->name }}</td>
                                            <td>${{ $product->price }}</td>
                                            <td>{{ $product->category }}</td>
                                            <td class="text-truncate" style="max-width: 150px;">{{ $product->details }}</td>
                                            <td>
                                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}"
                                                    class="card-img-top p-3" alt="{{ $product->name }}"
                                                    style="height: 200px; object-fit: contain;">
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('Delete this product?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($products->isEmpty())
                            <div class="alert alert-warning text-center mt-3">
                                <i class="fas fa-exclamation-circle"></i> No products found!
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script>
        $(document).ready(function () {
            const toggleBtn = $("#toggleViewBtn");
            const cardView = $("#cardView");
            const tableView = $("#tableView");
            const searchInput = $("#productSearch");

            toggleBtn.on("click", function () {
                cardView.toggle();
                tableView.toggle();

                if (cardView.is(":visible")) {
                    toggleBtn.html('<i class="fas fa-table"></i> Table View');
                } else {
                    toggleBtn.html('<i class="fas fa-th"></i> Card View');
                }
            });

            searchInput.on("input", function () {
                let query = $(this).val().toLowerCase();

                if (query.length < 3) {
                    $(".product-card").show();
                    $(".product-row").show();
                    return;
                }

                $(".product-card").each(function () {
                    let productName = $(this).find(".card-title").text().toLowerCase();
                    $(this).toggle(productName.includes(query));
                });

                $(".product-row").each(function () {
                    let productName = $(this).find("td:first").text().toLowerCase();
                    $(this).toggle(productName.includes(query));
                });
            });
        });
    </script>
@endpush