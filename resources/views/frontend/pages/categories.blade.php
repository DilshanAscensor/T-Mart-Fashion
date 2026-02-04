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

                    <a href="/item" class="category-card">
                        <img src="https://thumbs.dreamstime.com/b/young-handsome-elegant-man-sitting-chair-wearing-black-suit-sunglasses-isolated-over-vintage-background-76206423.jpg"
                            alt="Men's Collection" loading="lazy">
                        <div class="category-overlay">
                            <h2 class="category-title">Men's</h2>
                            <p class="category-desc">Tailored suits, premium casual wear, luxury outerwear — refined
                                masculinity for every occasion.</p>
                            <div class="category-count">180+ items</div>
                        </div>
                    </a>

                    <a href="#" class="category-card">
                        <img src="https://thumbs.dreamstime.com/b/handsome-fashion-male-model-man-dressed-elegant-suit-portrait-sexy-studio-lights-background-100665504.jpg"
                            alt="Women's Collection" loading="lazy">
                        <div class="category-overlay">
                            <h2 class="category-title">Women's</h2>
                            <p class="category-desc">Elegant dresses, statement pieces, sophisticated everyday luxury —
                                designed to empower and captivate.</p>
                            <div class="category-count">220+ items</div>
                        </div>
                    </a>

                    <a href="#" class="category-card">
                        <img src="https://www.sheknows.com/wp-content/uploads/2023/09/Screen-Shot-2023-09-21-at-2.42.38-PM.png?w=1024"
                            alt="Kids Collection" loading="lazy">
                        <div class="category-overlay">
                            <h2 class="category-title">Kids</h2>
                            <p class="category-desc">Charming & premium outfits for little ones — comfort meets elegance
                                from toddlers to teens.</p>
                            <div class="category-count">140+ items</div>
                        </div>
                    </a>

                    <a href="#" class="category-card">
                        <img src="https://thumbs.dreamstime.com/b/luxury-accessories-exquisite-watches-jewelry-handbags-reflective-granite-captivating-close-up-photograph-showcasing-288033349.jpg"
                            alt="Accessories" loading="lazy">
                        <div class="category-overlay">
                            <h2 class="category-title">Accessories</h2>
                            <p class="category-desc">Timeless jewelry, luxury handbags, belts & watches — the perfect
                                finishing touch.</p>
                            <div class="category-count">90+ items</div>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    @endsection
