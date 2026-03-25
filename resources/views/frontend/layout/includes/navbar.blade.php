 <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
 <header>
     <div class="nav-container">
         <div class="logo">T MART</div>
         <div class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></div>
         <nav id="navMenu">
             <div class="mobile-close" id="closeMenu"
                 style="display:none; text-align:right; font-size:2rem; cursor:pointer; color:var(--primary);">
                 ×
             </div>
             <a href="/">Home</a>
             <a href="{{ route('products.index') }}">Products</a>
             <a href="/categories">Categories</a>
             <a href="/about-us">About</a>
             <a href="/contact-us">Contact</a>

             <!-- Cart Icon with Count -->
             <a href="{{ route('cart') }}" class="cart-icon-link">
                 <i class="fas fa-shopping-cart"></i>

                 <span class="cart-count">
                     {{ session('cart') ? count(session('cart')) : 0 }}
                 </span>
             </a>

         </nav>
     </div>
 </header>

 <script>
     const menuToggle = document.getElementById('menuToggle');
     const closeMenu = document.getElementById('closeMenu');
     const navMenu = document.getElementById('navMenu');

     menuToggle.addEventListener('click', () => {
         navMenu.classList.add('active');
         closeMenu.style.display = 'block';
     });

     closeMenu.addEventListener('click', () => {
         navMenu.classList.remove('active');
         closeMenu.style.display = 'none';
     });
 </script>
