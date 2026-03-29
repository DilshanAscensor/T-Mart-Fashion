  @extends('frontend.layout.main', ['titlePage' => 'Cart'])
  @section('content')
      <style>
          .page-loader {
              position: fixed;
              inset: 0;
              background: rgba(85, 85, 85, 0.274);
              display: none;
              align-items: center;
              justify-content: center;
              z-index: 9999;
          }

          body.loading .page-loader {
              display: flex;
          }

          .spinner {
              width: 40px;
              height: 40px;
              border: 3px solid #eee;
              border-top: 3px solid #000;
              border-radius: 50%;
              animation: spin 0.7s linear infinite;
          }

          @keyframes spin {
              to {
                  transform: rotate(360deg);
              }
          }

          button:disabled {
              background: #d4af37cc !important;
              border-color: #ccc !important;
              color: #ccc;
              cursor: not-allowed;
              pointer-events: none;
              opacity: .6;
          }

          .btn-start-shopping {
              font-size: 15px;
              border-radius: 10px !important;
          }
      </style>

      <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">

      <section>

          <h1 class="page-title">Your Shopping Cart</h1>

          <div class="cart-container">
              <div class="cart-items">
                  @if (session()->has('cart') && count(session('cart')) > 0)
                      @foreach (session('cart') as $id => $item)
                          <div class="cart-item" data-product-id="{{ $id }}">
                              <div class="item-image">

                                  <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                              </div>
                              <div class="item-details">
                                  <h4>{{ $item['name'] }}</h4>

                                  <!-- Show variant only if you stored color/size -->
                                  @if (!empty($item['color']) || !empty($item['size']))
                                      <div class="variant">
                                          Color: {{ $item['color'] ?? 'N/A' }}
                                          • Size: {{ $item['size'] ?? 'N/A' }}
                                      </div>
                                  @endif

                                  <div class="price">LKR {{ number_format($item['price'], 0) }}</div>

                                  <div class="quantity-control">
                                      <button class="qty-btn decrease" data-id="{{ $id }}">-</button>
                                      <input type="text" class="qty-input" value="{{ $item['quantity'] }}" min="1"
                                          readonly style="text-align: center;">
                                      <button class="qty-btn increase" data-id="{{ $id }}">+</button>
                                  </div>
                              </div>
                              <div class="item-actions">
                                  <i class="fas fa-trash-alt remove-btn" data-id="{{ $id }}"></i>
                              </div>
                          </div>
                      @endforeach
                  @else
                      <div class="empty-cart-message text-center py-8">
                          <h3>Your cart is empty</h3>
                          <p style="margin-bottom: 50px">Looks like you haven't added anything yet.</p>
                          <a href="{{ route('categories.index') }}" class="btn btn-primary mt-4  btn-start-shopping">Start
                              Shopping</a>
                      </div>
                  @endif
              </div>

              <div class="cart-summary">
                  <div class="summary-title">Order Summary</div>

                  <?php
                  $subtotal = 0;
                  $itemCount = 0;
                  ?>
                  @if (session('cart'))
                      @foreach (session('cart') as $item)
                          <?php
                          $subtotal += $item['price'] * $item['quantity'];
                          $itemCount += $item['quantity'];
                          ?>
                      @endforeach
                  @endif

                  <div class="summary-row">
                      <span>Subtotal ({{ $itemCount }} items)</span>
                      <span>LKR {{ number_format($subtotal, 0) }}</span>
                  </div>
                  <div class="summary-row">
                      <span>Shipping</span>
                      <span>Calculated at checkout</span>
                  </div>


                  <div class="summary-total">
                      <span>Total</span>
                      <span>LKR {{ number_format($subtotal, 0) }}</span>
                  </div>

                  <div class="action-buttons">

                      @if ($itemCount > 0)
                          <a href="{{ url('checkout') }}" class="btn btn-primary">
                              Proceed to Checkout
                          </a>
                      @else
                          <button class="btn btn-primary disabled" disabled>
                              Proceed to Checkout
                          </button>
                      @endif

                      <a href="{{ route('categories.index') }}" class="btn btn-outline">
                          Continue Shopping
                      </a>

                  </div>
              </div>
          </div>
      </section>

      <div class="page-loader">
          <div class="spinner"></div>
      </div>

      <script>
          if (document.querySelectorAll('.cart-item').length === 0) {
              document.querySelector('.btn-primary').classList.add('disabled')
          }

          document.addEventListener("DOMContentLoaded", function() {

              /* ==============================
                 CREATE LOADER
              ============================== */
              const loader = document.createElement("div");
              loader.className = "page-loader";
              loader.innerHTML = '<div class="spinner"></div>';
              document.body.appendChild(loader);

              function showLoader() {
                  document.body.classList.add("loading");
              }

              function hideLoader() {
                  document.body.classList.remove("loading");
              }


              /* ==============================
                 QUANTITY UPDATE
              ============================== */
              document.querySelectorAll('.qty-btn').forEach(btn => {
                  btn.addEventListener('click', function() {

                      const id = this.dataset.id;
                      const input = this.parentElement.querySelector('.qty-input');
                      let val = parseInt(input.value);

                      if (this.classList.contains('increase')) {
                          val++;
                      }

                      if (this.classList.contains('decrease') && val > 1) {
                          val--;
                      }

                      input.value = val;

                      showLoader();

                      fetch("{{ route('cart.update') }}", {
                              method: "POST",
                              headers: {
                                  "Content-Type": "application/json",
                                  "X-CSRF-TOKEN": "{{ csrf_token() }}"
                              },
                              body: JSON.stringify({
                                  id: id,
                                  quantity: val
                              })
                          })
                          .then(res => res.json())
                          .then(data => {
                              location.reload();
                          })
                          .catch(err => {
                              hideLoader();
                              console.log(err);
                          });

                  });
              });


              /* ==============================
                 REMOVE ITEM
              ============================== */
              document.querySelectorAll('.remove-btn').forEach(btn => {
                  btn.addEventListener('click', function() {

                      const id = this.dataset.id;

                      if (!confirm("Remove this item?")) return;

                      showLoader();

                      fetch("{{ route('cart.remove') }}", {
                              method: "POST",
                              headers: {
                                  "Content-Type": "application/json",
                                  "X-CSRF-TOKEN": "{{ csrf_token() }}"
                              },
                              body: JSON.stringify({
                                  id: id
                              })
                          })
                          .then(res => res.json())
                          .then(data => {
                              location.reload();
                          })
                          .catch(err => {
                              hideLoader();
                          });

                  });
              });

          });
      </script>
  @endsection
