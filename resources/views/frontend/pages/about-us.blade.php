  @extends('frontend.layout.main', ['titlePage' => 'About-Us'])
  @section('content')
      <link rel="stylesheet" href="{{ asset('assets/css/about.css') }}">
      <section class="section" style="padding-bottom: 0">
          <h2 class="section-title">Our Story</h2>
          <div class="about-content">
              <p>T MART was born from a simple vision: to create a space where <span class="highlight">premium
                      quality</span> meets <span class="highlight">accessible luxury</span>.</p>
              <p>Founded in Colombo in 2026, we started with one goal — to offer fashion that feels personal,
                  powerful, and enduring. We believe clothing is more than fabric; it's expression, confidence, and
                  identity.</p>
              <p>Today, T MART stands as a curated destination for individuals who value craftsmanship, thoughtful
                  design, and pieces that transition effortlessly from season to season.</p>
          </div>
      </section>

      <section class="section" style="padding-bottom:0">
          <h2 class="section-title">Our Values</h2>
          <div class="values-grid">
              <div class="value-card">
                  <div class="value-icon"><i class="fas fa-gem"></i></div>
                  <h3 class="value-title">Premium Craftsmanship</h3>
                  <p>Every piece is made with meticulous attention to detail using high-quality materials that last
                      beyond trends.</p>
              </div>

              <div class="value-card">
                  <div class="value-icon"><i class="fas fa-leaf"></i></div>
                  <h3 class="value-title">Sustainable Luxury</h3>
                  <p>We choose responsible sourcing and ethical production without compromising on elegance or
                      comfort.</p>
              </div>

              <div class="value-card">
                  <div class="value-icon"><i class="fas fa-heart"></i></div>
                  <h3 class="value-title">Customer First</h3>
                  <p>Your confidence and satisfaction guide every decision we make — from design to delivery.</p>
              </div>

              <div class="value-card">
                  <div class="value-icon"><i class="fas fa-infinity"></i></div>
                  <h3 class="value-title">Timeless Design</h3>
                  <p>We create wardrobe essentials that remain relevant year after year, never fast fashion.</p>
              </div>
          </div>
      </section>

      <section class="section" style="padding-bottom:0">
          <h2 class="section-title">Our Promise</h2>
          <div class="about-content" style="text-align: center;">
              <p style="font-size: 1.3rem; font-style: italic; max-width: 800px; margin: 0 auto;">
                  “We don’t just sell clothes. We craft confidence, one carefully considered piece at a time.”
              </p>
              <p style="margin-top: 2.5rem; font-weight: 500;">— T MART Team, Colombo 2026</p>
          </div>
      </section>
  @endsection
