@extends('frontend.layout.main', ['titlePage' => 'Product'])
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/item.css') }}">
    <style>
        /* Remove arrows in Chrome, Safari, Edge */
        .qty-input::-webkit-outer-spin-button,
        .qty-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Remove arrows in Firefox */
        .qty-input {
            -moz-appearance: textfield;
        }

        .qty-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .qty-input {
            width: 60px;
            text-align: center;
            padding: 6px;
        }

        .qty-increase,
        .qty-decrease {
            padding: 6px 12px;
            cursor: pointer;
        }
    </style>
    <section>
        <div class="product-container">
            <div class="product-gallery">
                <div class="main-image">
                    @if ($product->images->first())
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}"
                            id="mainImg">
                    @endif
                </div>
                <div class="thumbnails">
                    @foreach ($product->images as $image)
                        <div class="thumb {{ $loop->first ? 'active' : '' }}"
                            data-src="{{ asset('storage/' . $image->image_path) }}">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }} thumbnail"
                                loading="lazy" decoding="async">
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="product-info">
                <h1>{{ $product->name }}</h1>
                <div class="price">LKR {{ number_format($product->price, 2) }}</div>

                <div class="variant-colors">
                    @foreach ($product->variants->pluck('color')->unique() as $color)
                        <div class="color-option" style="background:{{ $color }};" data-color="{{ $color }}">
                        </div>
                    @endforeach

                </div>

                <div class="sizes">
                    <label>Size</label>
                    <div class="size-buttons">
                        @foreach ($product->variants->pluck('size')->unique() as $size)
                            <button class="size-btn">{{ $size }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="quantity">
                    <label>Quantity</label>
                    <div class="qty-wrapper">
                        <button type="button" class="qty-decrease">-</button>
                        <input type="number" class="qty-input" value="1" min="1">
                        <button type="button" class="qty-increase">+</button>
                    </div>
                </div>

                <div class="action-buttons">
                    <button type="button" class="btn-primary text-center add-to-cart-btn"
                        data-url="{{ route('cart.add', ':id') }}" data-product-id="{{ $product->id }}">
                        Add to Cart
                    </button>
                </div>
                <div class="tabs">
                    <div class="tab-headers">
                        <div class="tab-header active" data-tab="desc">Description</div>
                        <div class="tab-header" data-tab="size">Size Guide</div>
                    </div>

                    <div class="tab-content active" id="desc">
                        <p>{{ $product->description }}</p>

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
    <script>
        const variants = @json($product->variants);


        document.addEventListener('DOMContentLoaded', function() {

            const firstColor = document.querySelector('.color-option');
            const firstSize = document.querySelector('.size-btn');

            if (firstColor) {
                firstColor.classList.add('active');
                selectedColor = firstColor.dataset.color;
            }

            if (firstSize) {
                firstSize.classList.add('active');
                selectedSize = firstSize.innerText;
            }

            findVariant();
        });


        let selectedColor = null;
        let selectedSize = null;
        let selectedVariant = null;

        // Color select
        document.querySelectorAll('.color-option').forEach(el => {
            el.addEventListener('click', function() {
                document.querySelectorAll('.color-option').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                selectedColor = this.dataset.color;

                findVariant();
            });
        });

        // Size select
        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                selectedSize = this.innerText;

                findVariant();
            });
        });

        function findVariant() {
            if (selectedColor && selectedSize) {
                selectedVariant = variants.find(v =>
                    v.color === selectedColor && v.size === selectedSize
                );

                if (selectedVariant) {
                    document.querySelector('.qty-input').max = selectedVariant.stock;

                    if (selectedVariant.stock <= 0) {
                        if (selectedVariant.stock <= 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Out of Stock',
                                text: 'This variant is currently unavailable.',
                            });

                            document.querySelector('.add-to-cart-btn').disabled = true;
                        } else {
                            document.querySelector('.add-to-cart-btn').disabled = false;
                        }
                    }
                }
            }
        }

        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                if (!selectedVariant) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Selection Required',
                        text: 'This variant is currently unavailable.',
                    });

                    return;
                }

                const qty = document.querySelector('.qty-input').value;

                if (qty > selectedVariant.stock) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Out of Stock',
                            text: 'This variant is currently unavailable.',
                        });


                    return;
                }

                const baseUrl = this.getAttribute('data-url');
                const productId = this.getAttribute('data-product-id');
                const url = baseUrl.replace(':id', productId);

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            variant_id: selectedVariant.id,
                            quantity: qty
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelector('.cart-count').textContent = data.cartCount;
                        }
                    });
            });
        });

        const qtyInput = document.querySelector('.qty-input');

        document.querySelector('.qty-increase').addEventListener('click', () => {
            let max = selectedVariant ? selectedVariant.stock : 999;
            let value = parseInt(qtyInput.value);

            if (value < max) {
                qtyInput.value = value + 1;
            }
        });

        document.querySelector('.qty-decrease').addEventListener('click', () => {
            let value = parseInt(qtyInput.value);

            if (value > 1) {
                qtyInput.value = value - 1;
            }
        });
    </script>
@endsection
