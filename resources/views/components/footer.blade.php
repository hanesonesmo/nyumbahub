<footer class="footer-premium">
    <div class="footer-premium-container">
        <div class="footer-premium-grid">
            
            {{-- Column 1: Company --}}
            <div class="footer-col company-col">
                <a href="{{ route('home') }}" class="footer-brand">
                    <img src="{{ asset('images/nyumbahublogo.png') }}" alt="{{ __('NyumbaHub Logo') }}" class="footer-logo">
                    <span class="brand-name">{{ __('Nyumba') }}<span>{{ __('Hub') }}</span></span>
                </a>
                <p class="company-desc">
                    {{ __('Your trusted real estate marketplace in Arusha. Discover, rent, buy, and sell properties with confidence.') }}
                </p>
                <div class="social-icons">
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="X / Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="#" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="#" aria-label="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>

            {{-- Column 2: Quick Links --}}
            <div class="footer-col">
                <h4 class="footer-heading">{{ __('Quick Links') }}</h4>
                <ul class="footer-links-list">
                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li><a href="{{ route('listings.index') }}">{{ __('Properties') }}</a></li>
                    <li><a href="{{ route('services') }}">{{ __('Services') }}</a></li>
                    <li><a href="{{ route('about') }}">{{ __('About Us') }}</a></li>
                    <li><a href="{{ route('become-agent') }}">{{ __('Become an Agent') }}</a></li>
                </ul>
            </div>

            {{-- Column 3: Support --}}
            <div class="footer-col">
                <h4 class="footer-heading">{{ __('Support') }}</h4>
                <ul class="footer-links-list">
                    <li><a href="{{ route('help-center') }}">{{ __('Help Center') }}</a></li>
                    <li><a href="{{ route('help-center') }}#faqs">{{ __('FAQs') }}</a></li>
                    <li><a href="{{ route('privacy-policy') }}">{{ __('Privacy Policy') }}</a></li>
                    <li><a href="{{ route('terms') }}">{{ __('Terms & Conditions') }}</a></li>
                    <li><a href="{{ route('contact') }}">{{ __('Contact Us') }}</a></li>
                </ul>
            </div>

            {{-- Column 4: Contact Information --}}
            <div class="footer-col">
                <h4 class="footer-heading">{{ __('Contact Information') }}</h4>
                <ul class="footer-contact-list">
                    <li>
                        <i class="fa-solid fa-location-dot"></i>
                        <span>{{ __('Arusha, Tanzania') }}</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-phone"></i>
                        <a href="tel:+255652094255">+255 652 094 255</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope"></i>
                        <a href="mailto:nyumbahub26@gmail.com">nyumbahub26@gmail.com</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-clock"></i>
                        <span>{{ __('Mon - Sat: 8:00 AM - 6:00 PM') }}</span>
                    </li>
                </ul>
            </div>

        </div>

        {{-- Footer Bottom --}}
        <div class="footer-premium-bottom">
            <div class="copyright">
                &copy; {{ date('Y') }} {{ __('NyumbaHub. All Rights Reserved.') }}
            </div>
            <div class="legal-links">
                <a href="{{ route('privacy-policy') }}">{{ __('Privacy Policy') }}</a>
                <span class="divider">•</span>
                <a href="{{ route('terms') }}">{{ __('Terms & Conditions') }}</a>
            </div>
        </div>
    </div>
</footer>
