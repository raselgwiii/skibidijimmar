@extends('layouts.app')

@section('content')
<div class="wrapper wrapper-content">
    <div class="animated fadeInRightBig">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Edit Product</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" 
                                               value="{{ old('name', $product->name) }}" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" id="description" 
                                                  rows="3">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="number" step="0.01" class="form-control" name="price" 
                                               id="price" value="{{ old('price', $product->price) }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="stock_quantity">Stock Quantity</label>
                                        <input type="number" class="form-control" name="stock_quantity" 
                                               id="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="category_id">Category</label>
                                        <select class="form-control" name="category_id" id="category_id">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->category_id }}" 
                                                    {{ old('category_id', $product->category_id) == $category->category_id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="image_url">Product Image</label>
                                        @if($product->image_url)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $product->image_url) }}" 
                                                     alt="Current Image" style="max-height: 100px;">
                                            </div>
                                        @endif
                                        <input type="file" class="form-control" name="image_url" id="image_url">
                                        <small class="text-muted">Leave empty to keep current image</small>
                                    </div>
                                    
                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-primary">Update Product</button>
                                        <a href="{{ route('products.index') }}" class="btn btn-default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 