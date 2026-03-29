@extends('frontend.layout.main', ['titlePage' => 'Home'])
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    <section class="hero-full" style="max-width: 100%">
        <div class="hero-content">
            <h1>Discover Your <span>Signature Style</span></h1>
            <p>Elevate your wardrobe with premium collections crafted for the modern individual. New Season 2026 now
                live.</p>
            <a href="{{ url('/categories') }}" class="hero-btn">Shop the Collection</a>
        </div>
    </section>

    <section>
        <div class="section-title">
            <h2>Explore Categories</h2>
            <p>Find the perfect look for every occasion</p>
        </div>
        <div class="categories">
            @foreach ($categories as $category)
                <a href="{{ route('category.products', $category->slug) }}">
                    <div class="card">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" loading="lazy"
                            decoding="async">
                        <div class="overlay">{{ $category->name }}</div>
                    </div>
                </a>
            @endforeach


        </div>
        @if ($categoriesCount > 2)
            <div class="mt-4" style="display: flex; justify-content:center">

                <a href="{{ url('/categories') }}" class="hero-btn">See All Categories</a>
            </div>
        @endif
    </section>

    <section>
        <div class="section-title">
            <h2>New Arrivals</h2>
            <p>Handpicked fresh styles for 2026</p>
        </div>
        <div class="products">
            @foreach ($products as $product)
                <a href="{{ route('products.show', $product->id) }}">
                    <div class="product">
                        @if ($product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                alt="{{ $product->name }}">
                        @endif
                        <h4>{{ $product->name }}</h4>
                        <span>LKR {{ number_format($product->price, 2) }}</span>
                    </div>
                </a>
            @endforeach

        </div>
    </section>

    <section>
        <div class="cta">
            <h2>Unleash Your Style</h2>
            <p>Where luxury meets confidence. Premium fabrics, timeless designs, and effortless elegance for every
                moment.</p>
            <a href="{{ url('/categories') }}" class="hero-btn">Browse Full Collection</a>
        </div>
    </section>
@endsection
