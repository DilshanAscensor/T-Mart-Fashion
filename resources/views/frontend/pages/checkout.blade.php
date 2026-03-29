@extends('frontend.layout.main', ['titlePage' => 'Checkout'])
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/checkout.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <section>

        @if (session('success'))
            <script>
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        @endif

        <h1 class="page-title">Checkout</h1>
        <form id="checkoutForm" method="POST" action="{{ route('checkout.store') }}">
            @csrf

            <div class="checkout-container">
                <div class="checkout-left">

                    <!-- SHIPPING ADDRESS -->
                    <div class="section-card">
                        <div class="section-title">Shipping Address</div>

                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}"
                                placeholder="Dilshan Perera" required>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label>Email Address *</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    placeholder="example@email.com" required>
                            </div>

                            <div class="form-group">
                                <label>Phone Number *</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}"
                                    placeholder="+94 77 123 4567" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label>Address Line 1 *</label>
                                <input type="text" name="address1" value="{{ old('address1') }}"
                                    placeholder="No. 123, Galle Road" required>
                            </div>

                            <div class="form-group">
                                <label>Address Line 2</label>
                                <input type="text" name="address2" value="{{ old('address2') }}"
                                    placeholder="Apartment, suite, etc">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label>City *</label>
                                <input type="text" name="city" value="{{ old('city') }}" placeholder="Colombo"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>District *</label>
                                <input type="text" name="district" value="{{ old('district') }}" placeholder="Colombo"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Postal Code</label>
                            <input type="text" name="postal_code" value="{{ old('postal_code') }}" placeholder="00300">
                        </div>

                    </div>


                    <!-- PAYMENT METHOD -->
                    <div class="section-card">
                        <div class="section-title">Payment Method</div>

                        <div class="payment-options">

                            <label class="payment-method active">
                                <input type="radio" name="payment_method" value="cod" checked>

                                <i class="fas fa-money-bill-wave payment-icon"></i>

                                <div>
                                    Cash on Delivery
                                </div>
                            </label>

                            <label class="payment-method disabled">
                                <input type="radio" name="payment_method" value="card" disabled>

                                <i class="fas fa-credit-card payment-icon"></i>

                                <div>
                                    Credit / Debit Card
                                    <small>(Coming Soon)</small>
                                </div>
                            </label>

                        </div>
                    </div>


                    <!-- ORDER REVIEW -->
                    <div class="section-card">
                        <div class="section-title">Review Your Order</div>

                        @php
                            $cart = session('cart', []);
                            $subtotal = 0;
                        @endphp

                        @forelse ($cart as $item)
                            @php
                                $itemTotal = $item['price'] * $item['quantity'];
                                $subtotal += $itemTotal;
                            @endphp

                            <div class="order-item">
                                <img src="{{ asset('storage/' . $item['image']) }}">

                                <div class="order-item-details">
                                    <h5>{{ $item['name'] }} × {{ $item['quantity'] }}</h5>

                                    <div>
                                        Color: {{ $item['color'] ?? '-' }} •
                                        Size: {{ $item['size'] ?? '-' }}
                                    </div>

                                    <div class="price">
                                        LKR {{ number_format($itemTotal, 2) }}
                                    </div>
                                </div>

                            </div>

                        @empty
                            <p>Your cart is empty</p>
                        @endforelse

                    </div>
                </div>


                @php
                    $itemCount = count($cart);
                    $shipping = 400;
                    // $tax = $subtotal * 0.1;
                    $tax = 0;
                    $discount = 0;
                    $total = $subtotal + $shipping + $tax - $discount;
                @endphp


                <!-- ORDER SUMMARY -->
                <div class="order-summary">

                    <div class="section-title">Order Summary</div>

                    <div class="summary-row">
                        <span>Subtotal ({{ $itemCount }} items)</span>
                        <span>LKR {{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>LKR {{ number_format($shipping, 2) }}</span>
                    </div>

                    <div class="summary-row">
                        <span>Tax</span>
                        <span>LKR {{ number_format($tax, 2) }}</span>
                    </div>

                    <div class="summary-total">
                        <span>Total</span>
                        <span>LKR {{ number_format($total, 2) }}</span>
                    </div>

                    <button type="submit" class="place-order-btn" id="placeOrderBtn">
                        <span class="btn-text">Place Order</span>
                        <span class="btn-loader" style="display:none">
                            Processing...
                        </span>
                    </button>
                </div>

            </div>

        </form>
    </section>

    <script>
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', () => {
                document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
                method.classList.add('active');
            });
        });
    </script>

    <script>
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {

            e.preventDefault();

            let form = this;
            let btn = document.getElementById('placeOrderBtn');

            btn.classList.add('loading');
            btn.querySelector('.btn-text').style.display = 'none';
            btn.querySelector('.btn-loader').style.display = 'inline';

            let formData = new FormData(form);

            fetch(form.action, {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(response => {

                    if (response.status === 'success') {

                        Swal.fire({
                            icon: 'success',
                            title: 'Order Confirmed',
                            text: response.message,
                            confirmButtonColor: '#000'
                        }).then(() => {
                            window.location.href = response.redirect;
                        });

                    } else {
                        throw new Error(response.message)
                    }

                })
                .catch(error => {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong'
                    });

                    btn.classList.remove('loading');
                    btn.querySelector('.btn-text').style.display = 'inline';
                    btn.querySelector('.btn-loader').style.display = 'none';

                });

        });
    </script>
@endsection
