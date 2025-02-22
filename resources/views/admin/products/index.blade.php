@extends('layouts.admin')

@section('content')
<section class="add-products">
    <h1 class="title">Add New Product</h1>
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="flex">
            <div class="inputBox">
                <input type="text" name="name" class="box" required placeholder="Enter product name">
                <select name="category" class="box" required>
                    <option value="" selected disabled>Select category</option>
                    <option value="Novel">Novel</option>
                    <option value="Programs">Programs</option>
                    <option value="Stories">Stories</option>
                    <option value="Poetry">Poetry</option>
                </select>
            </div>
            <div class="inputBox">
                <input type="number" min="0" name="price" class="box" required placeholder="Enter product price">
                <input type="file" name="image" required class="box" accept="image/jpg, image/jpeg, image/png">
            </div>
        </div>
        <textarea name="details" class="box" required placeholder="Enter product details" cols="30" rows="10"></textarea>
        <button type="submit" class="btn">Add Product</button>
    </form>
</section>

<section class="show-products">
    <h1 class="title">Products Added</h1>
    <div class="box-container">
        @foreach($products as $product)
        <div class="box">
            <div class="price">${{ $product->price }}/-</div>
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            <div class="name">{{ $product->name }}</div>
            <div class="cat">{{ $product->category }}</div>
            <div class="details">{{ $product->details }}</div>
            <div class="flex-btn">
                <a href="{{ route('admin.products.edit', $product->id) }}" class="option-btn">Update</a>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn" onclick="return confirm('Delete this product?')">Delete</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection