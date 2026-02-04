@extends('frontend.layout.main', ['titlePage' => 'Checkout'])
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/checkout.css') }}">

    <section>
        <h1 class="page-title">Checkout</h1>

        <div class="checkout-container">
            <div class="checkout-left">

                <!-- SHIPPING ADDRESS -->
                <div class="section-card">
                    <div class="section-title">Shipping Address</div>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" placeholder="Dilshan Perera" required>
                    </div>
                    <div class="form-group">
                        <label>Address Line 1</label>
                        <input type="text" placeholder="No. 123, Galle Road" required>
                    </div>
                    <div class="form-group">
                        <label>Address Line 2 (Optional)</label>
                        <input type="text" placeholder="Colombo 03">
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" placeholder="Colombo" required>
                        </div>
                        <div class="form-group">
                            <label>Postal Code</label>
                            <input type="text" placeholder="00300" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" placeholder="+94 77 123 4567" required>
                    </div>
                </div>

                <!-- PAYMENT METHOD -->
                <div class="section-card">
                    <div class="section-title">Payment Method</div>
                    <div class="payment-options">
                        <label class="payment-method active">
                            <input type="radio" name="payment" checked>
                            <i class="fas fa-credit-card payment-icon"></i>
                            <div>Credit / Debit Card</div>
                        </label>
                        <label class="payment-method">
                            <input type="radio" name="payment">
                            <i class="fas fa-money-bill-wave payment-icon"></i>
                            <div>Cash on Delivery</div>
                        </label>
                        {{-- <label class="payment-method">
                            <input type="radio" name="payment">
                            <i class="fab fa-paypal payment-icon"></i>
                            <div>PayPal</div>
                        </label> --}}
                    </div>

                    <!-- Card details (shown conditionally in real implementation) -->
                    {{-- <div class="form-group" style="margin-top: 1.5rem;">
                        <label>Card Number</label>
                        <input type="text" placeholder="1234 5678 9012 3456" maxlength="19">
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label>Expiry Date</label>
                            <input type="text" placeholder="MM/YY">
                        </div>
                        <div class="form-group">
                            <label>CVV</label>
                            <input type="text" placeholder="123" maxlength="4">
                        </div>
                    </div> --}}
                </div>

                <!-- ORDER REVIEW -->
                <div class="section-card">
                    <div class="section-title">Review Your Order</div>
                    <div class="order-item">
                        <img src="https://images.unsplash.com/photo-1551028719-00167b16eac5?w=200"
                            alt="Premium Leather Jacket">
                        <div class="order-item-details">
                            <h5>Premium Leather Jacket × 1</h5>
                            <div>Color: Black • Size: M</div>
                            <div class="price">LKR 7,200</div>
                        </div>
                    </div>
                    <div class="order-item">
                        <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=200"
                            alt="Urban Casual Shirt">
                        <div class="order-item-details">
                            <h5>Urban Casual Shirt × 2</h5>
                            <div>Color: White • Size: L</div>
                            <div class="price">LKR 6,800</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ORDER SUMMARY - Sticky -->
            <div class="order-summary">
                <div class="section-title">Order Summary</div>

                <div class="summary-row">
                    <span>Subtotal (3 items)</span>
                    <span>LKR 14,000</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>LKR 500</span>
                </div>
                <div class="summary-row">
                    <span>Estimated Tax</span>
                    <span>LKR 1,400</span>
                </div>
                <div class="summary-row">
                    <span>Discount (PROMO10)</span>
                    <span style="color:#27ae60;">- LKR 1,400</span>
                </div>

                <div class="summary-total">
                    <span>Total</span>
                    <span>LKR 14,500</span>
                </div>

                <button class="place-order-btn">Place Order</button>

                <p style="text-align:center; font-size:0.9rem; color:var(--muted); margin-top:1.5rem;">
                    By placing this order you agree to our <a href="#" style="color:var(--primary);">Terms &
                        Conditions</a>
                </p>
            </div>
        </div>

        <!-- MOBILE STICKY BOTTOM BAR -->
        <div class="sticky-bottom-bar">
            <div class="sticky-total">Total: LKR 14,500</div>
            <button class="sticky-place-order">Place Order</button>
        </div>
    </section>

    <script>
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', () => {
                document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
                method.classList.add('active');
            });
        });
    </script>
@endsection
