@extends('layouts.admin')

@section('content')
<section class="update-product">
    <h1 class="title">Update Product</h1>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="old_image" value="{{ $product->image }}">
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
        <input type="text" name="name" placeholder="Enter product name" required class="box" value="{{ $product->name }}">
        <input type="number" name="price" min="0" placeholder="Enter product price" required class="box" value="{{ $product->price }}">
        <select name="category" class="box" required>
            <option value="{{ $product->category }}" selected>{{ $product->category }}</option>
            <option value="Novel">Novel</option>
            <option value="Programs">Programs</option>
            <option value="Stories">Stories</option>
            <option value="Poetry">Poetry</option>
        </select>
        <textarea name="details" required placeholder="Enter product details" class="box" cols="30" rows="10">{{ $product->details }}</textarea>
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
        <div class="flex-btn">
            <button type="submit" class="btn" name="update_product">Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="option-btn">Go Back</a>
        </div>
    </form>
</section>
@endsection