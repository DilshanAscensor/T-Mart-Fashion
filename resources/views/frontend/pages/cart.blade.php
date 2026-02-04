  @extends('frontend.layout.main', ['titlePage' => 'Cart'])
  @section('content')
      <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">

      <section>
          <!-- NON-EMPTY CART (default view) -->
          <h1 class="page-title">Your Shopping Cart</h1>

          <div class="cart-container">
              <div class="cart-items">
                  <!-- Cart Item 1 -->
                  <div class="cart-item">
                      <div class="item-image">
                          <img src="https://images.unsplash.com/photo-1551028719-00167b16eac5?w=300"
                              alt="Premium Leather Jacket">
                      </div>
                      <div class="item-details">
                          <h4>Premium Leather Jacket</h4>
                          <div class="variant">Color: Black • Size: M</div>
                          <div class="price">LKR 7,200</div>

                          <div class="quantity-control">
                              <button class="qty-btn">-</button>
                              <input type="number" name="qty-input" class="qty-input" value="1" min="1">
                              <button class="qty-btn">+</button>
                          </div>
                      </div>
                      <div class="item-actions">
                          <i class="fas fa-trash-alt remove-btn"></i>
                      </div>
                  </div>

                  <!-- Cart Item 2 -->
                  <div class="cart-item">
                      <div class="item-image">
                          <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=300"
                              alt="Urban Casual Shirt">
                      </div>
                      <div class="item-details">
                          <h4>Urban Casual Shirt</h4>
                          <div class="variant">Color: White • Size: L</div>
                          <div class="price">LKR 3,400</div>

                          <div class="quantity-control">
                              <button class="qty-btn">-</button>
                              <input type="number" class="qty-input" value="2" min="1">
                              <button class="qty-btn">+</button>
                          </div>
                      </div>
                      <div class="item-actions">
                          <i class="fas fa-trash-alt remove-btn"></i>
                      </div>
                  </div>
              </div>

              <div class="cart-summary">
                  <div class="summary-title">Order Summary</div>

                  <div class="summary-row">
                      <span>Subtotal (3 items)</span>
                      <span>LKR 14,000</span>
                  </div>
                  <div class="summary-row">
                      <span>Shipping</span>
                      <span>Calculated at checkout</span>
                  </div>
                  <div class="summary-row">
                      <span>Estimated Tax</span>
                      <span>LKR 1,400</span>
                  </div>

                  <div class="summary-total">
                      <span>Total</span>
                      <span>LKR 15,400</span>
                  </div>

                  <div class="action-buttons">
                      <a href="/checkout" class="btn btn-primary">Proceed to Checkout</a>
                      <a href="categories.html" class="btn btn-outline">Continue Shopping</a>
                  </div>
              </div>
          </div>
      </section>

      <script>
          // Optional: Quantity buttons logic (demo)
          document.querySelectorAll('.qty-btn').forEach(btn => {
              btn.addEventListener('click', (e) => {
                  const input = e.target.parentElement.querySelector('.qty-input');
                  let val = parseInt(input.value);
                  if (e.target.textContent === '+') val++;
                  if (e.target.textContent === '-' && val > 1) val--;
                  input.value = val;
              });
          });
      </script>
  @endsection
