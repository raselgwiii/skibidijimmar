@extends('layouts.app')

@section('content')
<div class="wrapper wrapper-content">
    <div class="animated fadeInRightBig">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-title d-flex align-items-center">
                        <h5 class="mb-0">Add New Product</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <label for="name" class="form-label">Product Name</label>
                                        <input type="text" class="form-control form-control-lg" name="name" id="name" required 
                                               placeholder="Enter product name">
                                    </div>
                                    
                                    <div class="form-group mb-4">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" name="description" id="description" rows="4" 
                                                  placeholder="Describe your product"></textarea>
                                    </div>
                                    
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="price" class="form-label">Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₱</span>
                                                    <input type="number" step="0.01" class="form-control" name="price" 
                                                           id="price" required placeholder="0.00">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="stock_quantity" class="form-label">Stock Quantity</label>
                                                <input type="number" class="form-control" name="stock_quantity" 
                                                       id="stock_quantity" required placeholder="0">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group mb-4">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select class="form-control form-select" name="category_id" id="category_id">
                                            <option value="">Select a category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group mb-4">
                                        <label for="image_url" class="form-label">Product Image</label>
                                        <input type="file" class="form-control" name="image_url" id="image_url" 
                                               accept="image/*"
                                               onchange="previewImage(this);">
                                        <div id="imagePreview" class="mt-2" style="display: none;">
                                            <img id="preview" src="#" alt="Preview" 
                                                 style="max-height: 200px; max-width: 100%; object-fit: contain;">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group d-flex justify-content-between mt-5">
                                        <a href="{{ route('products.index') }}" class="btn btn-secondary px-4">Cancel</a>
                                        <button type="submit" class="btn btn-primary px-4">Save Product</button>
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
<script>
    function previewImage(input) {
        var preview = document.getElementById('preview');
        var previewDiv = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewDiv.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection 