@extends('layouts.app')

@section('content')
<style>
.page-header {
    padding: 1.5rem;
    margin-bottom: 2rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.page-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.add-product-btn {
    background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);
    color: white !important;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    border: none;
    text-decoration: none;
}

.add-product-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
    padding: 0.5rem;
}

.product-card {
    background: white;
    border-radius: 12px;
    transition: all 0.3s ease;
    position: relative;
    height: 100%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.product-image-wrapper {
    position: relative;
    padding-top: 150%; /* Adjust aspect ratio to make the image taller */
    overflow: hidden;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}
.product-image-wrapper {
    position: relative;
    padding-top: 150%; /* Adjust aspect ratio to make the image taller */
    overflow: hidden;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.product-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures the image fills the container */
    transition: transform 0.3s ease, filter 0.3s ease;
    filter: brightness(0.9) contrast(1.1);
}

.product-card:hover .product-image {
    transform: scale(1.05); /* Slight zoom effect */
    filter: brightness(1);
}

.product-category {
    position: absolute;
    top: -10px;
    right: 0.75rem;
    background: rgba(255, 255, 255, 0.9);
    padding: 0.2rem 0.5rem;
    border-radius: 12px;
    font-size: 0.7rem;
    color: #718096;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.product-price {
    color: #2d3748;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0.25rem;
}

.product-price span {
    color: #43cea2;
}

.product-name {
    font-size: 0.85rem;
    color: #4a5568;
    margin-bottom: 0.5rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.product-description {
    font-size: 0.75rem;
    color: #718096;
    margin-bottom: 0.75rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
}

.stock-badge {
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    border-radius: 10px;
    background: #ebf8ff;
    color: #3182ce;
    display: inline-block;
    margin-bottom: 0.75rem;
}

.product-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.action-btn {
    flex: 1;
    padding: 0.35rem;
    border-radius: 8px;
    font-size: 0.75rem;
    text-align: center;
    transition: all 0.2s ease;
    text-decoration: none;
    border: none;
    cursor: pointer;
}

.edit-btn {
    background: #ebf8ff;
    color: #3182ce !important;
}

.delete-btn {
    background: #fff5f5;
    color: #e53e3e !important;
}

.action-btn:hover {
    transform: translateY(-1px);
    filter: brightness(0.95);
}

.header-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.header-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0;
}

.add-btn {
    background: #00bf9a;
    color: white !important;
    padding: 0.5rem 1.25rem;
    border-radius: 8px;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    text-decoration: none;
    border: none;
}

.add-btn:hover {
    background: #00a383;
    transform: translateY(-1px);
}

.search-row {
    margin-bottom: 1.5rem;
}

.search-input-group {
    max-width: 500px;
    display: flex;
    align-items: stretch;
}

.search-input {
    flex: 1;
    padding: 0.5rem 1rem;
    border: 1px solid #e2e8f0;
    border-right: none;
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
    font-size: 0.9rem;
}

.search-input:focus {
    outline: none;
    border-color: #00bf9a;
}

.search-btn {
    padding: 0.5rem 1rem;
    background: #00bf9a;
    border: 1px solid #00bf9a;
    color: white;
    border-top-right-radius: 8px;
    border-bottom-right-radius: 8px;
    transition: all 0.2s ease;
}

.search-btn:hover {
    background: #00a383;
    border-color: #00a383;
}
</style>

<div class="wrapper wrapper-content">
    <div class="header-flex">
        <h2 class="header-title">Manage Products</h2>
        <a href="{{ route('products.create') }}" class="add-btn">
            <i class="fa fa-plus"></i>
            Add Product
        </a>
    </div>

    <div class="search-row">
        <form action="{{ route('products.index') }}" method="GET">
            <div class="search-input-group">
                <input type="text" 
                       name="search" 
                       class="search-input" 
                       placeholder="Search products..." 
                       value="{{ request('search') }}">
                <button type="submit" class="search-btn">
                    <i class="fa fa-search"></i> Search
                </button>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="products-grid">
        @forelse($products as $product)
        <div class="product-card">
            <div class="product-image-wrapper">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image">
            </div>
            <div class="product-info">
                <div class="product-category">{{ $product->category->name ?? 'No Category' }}</div>
                <div class="product-price">
                    <span>₱</span>{{ number_format($product->price, 2) }}
                </div>
                <h4 class="product-name">{{ $product->name }}</h4>
                <div class="product-description">
                    {{ Str::limit($product->description, 100) }}
                </div>
                <div class="stock-badge">
                    Stock: {{ $product->stock_quantity }}
                </div>
                <div class="product-actions">
                    <a href="{{ route('products.edit', $product->product_id) }}" class="action-btn edit-btn">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('products.destroy', $product->product_id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this product?')">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No products found.</div>
            </div>
        @endforelse
    </div>
</div>

@endsection