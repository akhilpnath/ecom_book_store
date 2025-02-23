@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Update Product</h5>
                        <a href="{{ route('admin.products.index') }}" 
                           class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Back to Products
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.update', $product->id) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="old_image" value="{{ $product->image }}">
                        
                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="img-fluid rounded"
                                 style="max-height: 200px;">
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" 
                                           name="name" 
                                           class="form-control" 
                                           required 
                                           value="{{ $product->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Price ($)</label>
                                    <input type="number" 
                                           name="price" 
                                           class="form-control" 
                                           required 
                                           value="{{ $product->price }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-select" required>
                                        <option value="{{ $product->category }}" selected>
                                            {{ $product->category }}
                                        </option>
                                        <option value="Novel">Novel</option>
                                        <option value="Programs">Programs</option>
                                        <option value="Stories">Stories</option>
                                        <option value="Poetry">Poetry</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Product Details</label>
                                    <textarea name="details" 
                                              class="form-control" 
                                              required 
                                              rows="4">{{ $product->details }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Update Image</label>
                                    <input type="file" 
                                           name="image" 
                                           class="form-control" 
                                           accept="image/jpg, image/jpeg, image/png">
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Product
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .product-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .form-label {
        font-weight: 500;
        color: var(--text-primary);
    }

    .card {
        border: none;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        border-radius: 10px;
    }

    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .btn {
        padding: 0.5rem 1rem;
        font-weight: 500;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
    }
</style>
@endsection