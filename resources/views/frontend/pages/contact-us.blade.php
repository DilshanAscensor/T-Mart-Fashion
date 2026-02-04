@extends('frontend.layout.main', ['titlePage' => 'Contact-Us'])
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}">
    <section style="padding-top: 0">
        <div class="page-header">
            <h1>Contact Us</h1>
            <p class="subtitle">We’re here to help — drop us a message or visit us in Colombo.</p>
        </div>

        <div class="contact-wrapper">
            <!-- LEFT – Contact Info -->
            <div class="contact-panel">
                <h2 class="panel-title">Reach Out</h2>

                <div class="info-list">
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>No. 45, Galle Road, Colombo 03, Sri Lanka</div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone-alt"></i>
                        <div>+94 11 234 5678</div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:hello@tmart.lk" style="color: white">hello@tmart.lk</a>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <div>Mon–Sat: 10:00 AM – 8:00 PM</div>
                    </div>
                </div>

                <div class="social-row">
                    <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-twitter"></i></a>
                </div>

                <div class="map-frame">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.797315!2d79.847!3d6.927!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae256db1a6771c5%3A0x2c63e344ab9a7536!2sGalle%20Rd%2C%20Colombo!5e0!3m2!1sen!2slk!4v1730000000000"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

            <!-- RIGHT – Form -->
            <div class="contact-panel">
                <h2 class="panel-title">Send Message</h2>

                <form>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" placeholder="Your full name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" placeholder="your@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone (optional)</label>
                        <input type="tel" id="phone" placeholder="+94 7x xxx xxxx">
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" placeholder="How can we help you today?" required></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Send Message</button>
                </form>
            </div>
        </div>
    </section>
@endsection
