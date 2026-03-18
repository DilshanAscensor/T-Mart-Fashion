    @extends('frontend.layout.main', ['titlePage' => 'Category'])
    @section('content')
        <link rel="stylesheet" href="{{ asset('assets/css/categories.css') }}">
        <section>
            <div class="page-header">
                <h1>Shop by Category</h1>
                <p>Discover premium collections crafted for elegance, confidence, and timeless style. Explore our curated
                    world of fashion.</p>
            </div>

            <div class="categories-container">
                <div class="categories-grid">

                    @foreach($categories as $category)
                        <a href="/item" class="category-card">
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                loading="lazy">
                            <div class="category-overlay">
                                <h2 class="category-title">{{ $category->name }}</h2>
                                <p class="category-desc">{{ Str::limit($category->description, 100) }}</p>
                                <div class="category-count">Explore {{ $category->products_count }} items</div>
                            </div>
                        </a>
                    @endforeach
                  

                </div>
            </div>
        </section>
    @endsection
