@extends('frontend.layout.main', ['titlePage' => 'Products' . (isset($category) ? ' - ' . $category->name : '')])

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/categories.css') }}">
    <!-- Reuse same CSS or create items.css if you want different styling -->

    <section>
        <!-- Header Area -->
        <div class="page-header">
            <h1>
                @if (isset($category))
                    {{ $category->name }} Collection
                @else
                    All Products
                @endif

            </h1>

            <p>
                @if (isset($category))
                    Discover our curated selection of premium {{ Str::lower($category->name) }}.
                @else
                    Browse our complete collection of elegant, timeless fashion pieces.
                @endif
            </p>

            <!-- Search Bar -->
            <div class="search-container" style="max-width: 600px; margin: 2rem auto;">
                <form action="{{ route('products.index') }}" method="GET" class="search-form">
                    <div class="search-input-wrapper">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search products by name or description..." class="search-input" autocomplete="off">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>

                    <!-- Preserve category filter if coming from category -->
                    @if (request('category') || request('category_id'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                    @endif
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="categories-container">
            <div class="categories-grid products-grid">

                @forelse($products as $product)
                <a href="{{ route('products.show', $product->id) }}" class="category-card product-card">
                        @if ($product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                alt="{{ $product->name }}" loading="lazy" class="product-image">
                        @endif

                        <div class="category-overlay">
                            <h2 class="product-title">{{ $product->name }}</h2>

                            <p class="category-desc">
                                {{ Str::limit($product->description ?? 'Premium quality item', 80) }}
                            </p>

                            <div class="product-meta">
                                @if ($product->price)
                                    <span class="price">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                @endif

                                @if ($product->reviews_count ?? 0 > 0)
                                    <span class="rating">
                                        ★ {{ number_format($product->reviews_avg_rating ?? 0, 1) }}
                                        ({{ $product->reviews_count }})
                                    </span>
                                @endif
                            </div>

                            <div class="category-count">
                                View Details →
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="no-results" style="grid-column: 1 / -1; text-align: center; padding: 4rem 1rem;">
                        <h3>No products found</h3>
                        <p>Try adjusting your search or browse other categories.</p>
                        <a href="{{ route('products.index') }}" class="btn" style=" color:red; text-decoration: underline;">Clear Search</a>
                    </div>
                @endforelse

            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $products->appends(request()->query())->links() }}
        </div>

    </section>

    <style>
        /* Quick extra styles – move to items.css later */
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }

        .product-card {
            aspect-ratio: 3/4;
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.06);
        }

        .search-form {
            display: flex;
            width: 100%;
        }

        .search-input-wrapper {
            display: flex;
            width: 100%;
            border: 2px solid #ddd;
            border-radius: 50px;
            overflow: hidden;
            background: white;
        }

        .search-input {
            flex: 1;
            border: none;
            padding: 0.9rem 1.5rem;
            font-size: 1.05rem;
        }

        .search-input:focus {
            outline: none;
        }

        .search-btn {
            background: #222;
            color: white;
            border: none;
            padding: 0 1.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .search-btn:hover {
            background: #000;
        }

        .product-meta {
            margin: 0.8rem 0;
            font-size: 0.95rem;
            color: #555;
        }

        .price {
            font-weight: bold;
            color: #e91e63;
            font-size: 1.1rem;
        }

        .no-results h3 {
            color: #666;
            margin-bottom: 1rem;
        }
        .product-title{
            font-size: 1.6rem;
            font-weight: 600;
        }
    </style>
@endsection
