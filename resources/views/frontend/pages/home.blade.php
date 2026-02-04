@extends('frontend.layout.main', ['titlePage' => 'Home'])
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    <section class="hero-full">
        <div class="hero-content">
            <h1>Discover Your <span>Signature Style</span></h1>
            <p>Elevate your wardrobe with premium collections crafted for the modern individual. New Season 2026 now
                live.</p>
            <a href="#" class="hero-btn">Shop the Collection</a>
        </div>
    </section>

    <section>
        <div class="section-title">
            <h2>Explore Categories</h2>
            <p>Find the perfect look for every occasion</p>
        </div>
        <div class="categories">
            <div class="card">
                <img src="https://images.unsplash.com/photo-1552374196-c4e7ffc6e126?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80"
                    alt="Men" loading="lazy" decoding="async">
                <div class="overlay">Men's</div>
            </div>
            <div class="card">
                <img src="https://images.unsplash.com/photo-1487222477894-8943e31ef7b2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80"
                    alt="Women" loading="lazy" decoding="async">
                <div class="overlay">Women's</div>
            </div>
            <div class="card">
                <img src="https://images.unsplash.com/photo-1622297840-00e960d5de0e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80"
                    alt="Kids" loading="lazy" decoding="async">
                <div class="overlay">Kids</div>
            </div>
        </div>
    </section>

    <section>
        <div class="section-title">
            <h2>New Arrivals</h2>
            <p>Handpicked fresh styles for 2026</p>
        </div>
        <div class="products">
            <div class="product">
                <img src="https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e" loading="lazy" decoding="async"
                    alt="Elegant Dress">
                <h4>Timeless Elegance Dress</h4>
                <span>LKR 4,800</span>
            </div>
            <div class="product">
                <img src="https://images.unsplash.com/photo-1551028719-00167b16eac5" loading="lazy" decoding="async"
                    alt="Luxury Jacket">
                <h4>Premium Leather Jacket</h4>
                <span>LKR 7,200</span>
            </div>
            <!-- Add 2 more as before or new Unsplash images -->
            <div class="product">
                <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab" loading="lazy" decoding="async"
                    alt="Casual Shirt">
                <h4>Urban Casual Shirt</h4>
                <span>LKR 3,400</span>
            </div>
            <div class="product">
                <img src="https://images.unsplash.com/photo-1525507119028-ed4c629a60a3" loading="lazy" decoding="async"
                    alt="Modern Outfit">
                <h4>Contemporary Set</h4>
                <span>LKR 5,600</span>
            </div>
        </div>
    </section>

    <section>
        <div class="cta">
            <h2>Unleash Your Style</h2>
            <p>Where luxury meets confidence. Premium fabrics, timeless designs, and effortless elegance for every
                moment.</p>
            <a href="#" class="hero-btn">Browse Full Collection</a>
        </div>
    </section>
@endsection
