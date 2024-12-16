@extends('layouts.app')
@section('content')
<style>
.stat-card {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    border-radius: 20px;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: rgba(255,255,255,0.1);
    transform: rotate(45deg);
    z-index: 0;
}

.stat-number {
    font-size: 3.5rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 0.2rem;
}

.stat-label {
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.8;
}

.stat-icon {
    position: absolute;
    right: -20px;
    bottom: -20px;
    font-size: 5rem;
    opacity: 0.2;
    transform: rotate(-15deg);
    transition: all 0.3s ease;
}

.stat-card:hover .stat-icon {
    transform: rotate(0deg) scale(1.1);
    opacity: 0.3;
}

.pulse {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.stat-badge {
    background: rgba(255, 255, 255, 0.98);
    border-radius: 15px;
    padding: 4px 10px 4px 4px;
    font-size: 0.75rem;
    font-weight: 500;
    color: #2d3748;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.stat-badge i {
    font-size: 0.7rem;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: white;
    transition: transform 0.3s ease;
}

.stat-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}

.stat-badge:hover i {
    transform: scale(1.1);
}

.badge-success {
    border: 1px solid rgba(72, 187, 120, 0.2);
}

.badge-success i {
    background: linear-gradient(135deg, #48bb78, #38a169);
}

.badge-primary {
    border: 1px solid rgba(66, 153, 225, 0.2);
}

.badge-primary i {
    background: linear-gradient(135deg, #4299e1, #3182ce);
}

.badge-dot {
    font-size: 1rem;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
}

/* Product Overview Styles */
.products-overview {
    margin-top: 2rem;
}

.products-overview-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 1.5rem;
    padding-left: 0.5rem;
    border-left: 4px solid #43cea2;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 1rem;
    padding: 0.5rem;
}

.product-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.product-image-wrapper {
    position: relative;
    padding-top: 65%;
    background: #f7fafc;
    overflow: hidden;
}

.product-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-info {
    padding: 0.75rem;
    position: relative;
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

.stock-badge {
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    border-radius: 10px;
    background: #ebf8ff;
    color: #3182ce;
    display: inline-block;
}
</style>

@section('head')
    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

<div class="wrapper wrapper-content">
    <div class="row g-4">
        <!-- Orders Card -->
        <div class="col-md-4">
            <div class="stat-card h-100 p-4" style="background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);">
                <div class="position-relative z-2">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="stat-label text-white">Orders</span>
                        <div class="stat-badge badge-success">
                            <i class="fa fa-signal"></i>
                            Active
                        </div>
                    </div>
                    <div class="stat-number text-white pulse">{{ $totalOrders ?? 0 }}</div>
                    <div class="stat-label text-white">Total Orders</div>
                </div>
                <i class="fa fa-shopping-cart stat-icon text-white"></i>
            </div>
        </div>

        <!-- Products Card -->
        <div class="col-md-4">
            <div class="stat-card h-100 p-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="position-relative z-2">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="stat-label text-white">Products</span>
                        <div class="stat-badge badge-primary">
                            <i class="fa fa-cube"></i>
                            In Stock
                        </div>
                    </div>
                    <div class="stat-number text-white">{{ $totalProducts ?? 0 }}</div>
                    <div class="stat-label text-white">Total Products</div>
                </div>
                <i class="fa fa-cubes stat-icon text-white"></i>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="col-md-4">
            <div class="stat-card h-100 p-4" style="background: linear-gradient(135deg, #FF416C 0%, #FF4B2B 100%);">
                <div class="position-relative z-2">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="stat-label text-white">Customers</span>
                        <div class="stat-badge badge-success">
                            <i class="fa fa-circle"></i>
                            Active
                        </div>
                    </div>
                    <div class="stat-number text-white">{{ $totalCustomers ?? 0 }}</div>
                    <div class="stat-label text-white">Total Customers</div>
                </div>
                <i class="fa fa-users stat-icon text-white"></i>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="products-overview">
        <h3 class="products-overview-title">Products Overview</h3>
        <div class="products-grid">
            @if(isset($products) && $products->count() > 0)
                @foreach($products as $product)
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image">
                    </div>
                    <div class="product-info">
                        <div class="product-category">Category {{ $product->category_id }}</div>
                        <div class="product-price">
                            <span>₱</span>{{ number_format($product->price, 2) }}
                        </div>
                        <h4 class="product-name">{{ $product->name }}</h4>
                        <div class="m-t text-right">
                            <span class="stock-badge badge-{{ $product->stock_quantity > 0 ? 'success' : 'danger' }}">
                                Stock: {{ $product->stock_quantity }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-info">No products available.</div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection