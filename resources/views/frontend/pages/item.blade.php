@extends('frontend.layout.main', ['titlePage' => 'Product'])
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/item.css') }}">
    <section>
        <div class="product-container">
            <div class="product-gallery">
                <div class="main-image">
                    <img src="https://images.unsplash.com/photo-1551028719-00167b16eac5?w=800"
                        alt="Premium Leather Jacket - Black" id="mainImg">
                </div>
                <div class="thumbnails">
                    <div class="thumb active" data-src="https://images.unsplash.com/photo-1551028719-00167b16eac5?w=800">
                        <img src="https://images.unsplash.com/photo-1551028719-00167b16eac5?w=200" alt="Black">
                    </div>
                    <div class="thumb" data-src="https://images.unsplash.com/photo-1520975954732-35dd22299614?w=800">
                        <img src="https://images.unsplash.com/photo-1520975954732-35dd22299614?w=200" alt="Side">
                    </div>
                    <div class="thumb" data-src="https://images.unsplash.com/photo-1552374196-1ab2a1c593e8?w=800">
                        <img src="https://images.unsplash.com/photo-1552374196-1ab2a1c593e8?w=200" alt="Detail">
                    </div>
                </div>
            </div>

            <div class="product-info">
                <h1>Premium Leather Jacket</h1>
                <div class="price">LKR 7,200</div>

                <div class="variant-colors">
                    <div class="color-option" style="background:#000;" data-color="Black"></div>
                    <div class="color-option" style="background:#8B4513;" data-color="Brown"></div>
                    <div class="color-option" style="background:#2F4F4F;" data-color="Charcoal"></div>
                </div>

                <div class="sizes">
                    <label>Size</label>
                    <div class="size-buttons">
                        <button class="size-btn">S</button>
                        <button class="size-btn active">M</button>
                        <button class="size-btn">L</button>
                        <button class="size-btn">XL</button>
                        <button class="size-btn">XXL</button>
                    </div>
                </div>

                <div class="quantity">
                    <label>Quantity</label>
                    <input type="number" class="qty-input" value="1" min="1">
                </div>

                <div class="action-buttons">
                    <a href="/cart" class="btn-primary text-center">Add to Cart</a>
                    {{-- @auth
                        @php
                            $isWishlisted = auth()->user()->wishlistProducts->contains($product->id);
                        @endphp

                        @if ($isWishlisted)
                            <form action="{{ route('wishlist.remove', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-secondary text-danger">
                                    <i class="fas fa-heart"></i> Remove from Wishlist
                                </button>
                            </form>
                        @else
                            <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-secondary">
                                    <i class="far fa-heart"></i> Add to Wishlist
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary">
                            <i class="far fa-heart"></i> Login to Wishlist
                        </a>
                    @endauth --}}
                </div>

                <div class="tabs">
                    <div class="tab-headers">
                        <div class="tab-header active" data-tab="desc">Description</div>
                        <div class="tab-header" data-tab="size">Size Guide</div>
                        <div class="tab-header" data-tab="reviews">Reviews (12)</div>
                    </div>

                    <div class="tab-content active" id="desc">
                        <p>Handcrafted from premium full-grain leather with a soft cotton lining. Features asymmetric
                            zip closure, multiple pockets, and ribbed cuffs & hem. Perfect for transitional weather and
                            elevated casual looks.</p>
                        <ul style="margin:1.5rem 0; padding-left:1.5rem;">
                            <li>100% genuine leather</li>
                            <li>YKK zippers</li>
                            <li>Interior pocket</li>
                            <li>Available in Black, Brown, Charcoal</li>
                        </ul>
                    </div>

                    <div class="tab-content" id="size">
                        <p>Model is 6'1" (185 cm) wearing size M.</p>
                        <table style="width:100%; margin-top:1.5rem; border-collapse:collapse;">
                            <tr style="border-bottom:1px solid rgba(212,175,55,0.2);">
                                <th style="padding:0.8rem; text-align:left;">Size</th>
                                <th style="padding:0.8rem; text-align:left;">Chest (cm)</th>
                                <th style="padding:0.8rem; text-align:left;">Length (cm)</th>
                            </tr>
                            <tr>
                                <td style="padding:0.8rem;">S</td>
                                <td>102</td>
                                <td>65</td>
                            </tr>
                            <tr>
                                <td style="padding:0.8rem;">M</td>
                                <td>108</td>
                                <td>67</td>
                            </tr>
                            <tr>
                                <td style="padding:0.8rem;">L</td>
                                <td>114</td>
                                <td>69</td>
                            </tr>
                            <tr>
                                <td style="padding:0.8rem;">XL</td>
                                <td>120</td>
                                <td>71</td>
                            </tr>
                        </table>
                    </div>

                    <div class="tab-content" id="reviews">
                        <p>Average Rating: <strong>4.8 / 5</strong></p>
                        <p style="margin:1.5rem 0;">"Best leather jacket I've owned. Quality is insane for the price."
                            – Akila, Colombo</p>
                        <!-- You can add more review snippets here -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Thumbnail switch
        const thumbs = document.querySelectorAll('.thumb');
        const mainImg = document.getElementById('mainImg');

        thumbs.forEach(thumb => {
            thumb.addEventListener('click', () => {
                thumbs.forEach(t => t.classList.remove('active'));
                thumb.classList.add('active');
                mainImg.src = thumb.dataset.src;
            });
        });

        // Tabs
        const tabHeaders = document.querySelectorAll('.tab-header');
        const tabContents = document.querySelectorAll('.tab-content');

        tabHeaders.forEach(header => {
            header.addEventListener('click', () => {
                tabHeaders.forEach(h => h.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));

                header.classList.add('active');
                document.getElementById(header.dataset.tab).classList.add('active');
            });
        });
    </script>
@endsection
