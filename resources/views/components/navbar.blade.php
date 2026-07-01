{{-- Premium Navigation Component --}}
<header class="premium-header" id="siteHeader">
    <div class="premium-container">
        
        {{-- Left: Brand --}}
        <a href="{{ route('home') }}" class="nav-brand">
            <div class="brand-logo">
                <img src="{{ asset('images/nyumbahublogo.png') }}" alt="{{ __('NyumbaHub Logo') }}">
            </div>
            <span class="brand-name">{{ __('Nyumba') }}<span>{{ __('Hub') }}</span></span>
        </a>

        {{-- Mobile Toggle Button --}}
        <button class="mobile-toggle-btn" id="mobileMenuBtn" aria-label="Toggle navigation drawer">
            <span></span>
            <span></span>
            <span></span>
        </button>

        {{-- Center/Right: Desktop Navigation --}}
        <nav class="desktop-nav">
            <ul class="nav-links">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        {{ __('Home') }}
                    </a>
                </li>
                
                {{-- Mega Menu for Properties --}}
                <li class="nav-item nav-item-dropdown">
                    <a href="{{ route('listings.index') }}" class="nav-link {{ request()->routeIs('listings.*') ? 'active' : '' }}">
                        {{ __('Properties') }} <i class="fa-solid fa-chevron-down" style="font-size: 10px; margin-left: 4px;"></i>
                    </a>
                    
                    <div class="mega-menu-wrapper">
                        <div class="mega-menu-column">
                            <h4>{{ __('Listing Status') }}</h4>
                            <ul class="mega-menu-list">
                                <li>
                                    <a href="{{ route('listings.index') }}" class="mega-item">
                                        <div class="mega-item-icon"><i class="fa-solid fa-layer-group"></i></div>
                                        <div class="mega-item-text">{{ __('All Properties') }}</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('listings.index', ['type' => 'sale']) }}" class="mega-item">
                                        <div class="mega-item-icon"><i class="fa-solid fa-tag"></i></div>
                                        <div class="mega-item-text">{{ __('For Sale') }}</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('listings.index', ['type' => 'rent']) }}" class="mega-item">
                                        <div class="mega-item-icon"><i class="fa-solid fa-key"></i></div>
                                        <div class="mega-item-text">{{ __('For Rent') }}</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="mega-menu-column">
                            <h4>{{ __('Property Types') }}</h4>
                            <ul class="mega-menu-list">
                                <li>
                                    <a href="{{ route('listings.index', ['category' => 'apartment']) }}" class="mega-item">
                                        <div class="mega-item-icon"><i class="fa-solid fa-building"></i></div>
                                        <div class="mega-item-text">{{ __('Apartments') }}</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('listings.index', ['category' => 'villa']) }}" class="mega-item">
                                        <div class="mega-item-icon"><i class="fa-solid fa-house"></i></div>
                                        <div class="mega-item-text">{{ __('Houses') }}</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('listings.index', ['category' => 'commercial']) }}" class="mega-item">
                                        <div class="mega-item-icon"><i class="fa-solid fa-city"></i></div>
                                        <div class="mega-item-text">{{ __('Commercial') }}</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('listings.index', ['category' => 'land']) }}" class="mega-item">
                                        <div class="mega-item-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                                        <div class="mega-item-text">{{ __('Land') }}</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a href="{{ route('services') }}" class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}">
                        {{ __('Services') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                        {{ __('About Us') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('become-agent') }}" class="nav-link btn-cta">
                        {{ __('Become an Agent') }} <i class="fa-solid fa-arrow-right" style="font-size:12px;"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                        {{ __('Contact') }}
                    </a>
                </li>
            </ul>

            {{-- Right Side Actions --}}
            <div class="nav-actions">
                
                {{-- Expandable Search --}}
                <div class="search-wrapper" id="navSearchWrapper">
                    <form action="{{ route('listings.index') }}" method="GET" style="margin:0; display:flex;">
                        <input type="text" name="search" class="search-input" placeholder="{{ __('Search Arusha...') }}" aria-label="Search">
                        <button type="button" class="search-icon-btn trigger" id="searchTriggerBtn">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>

                {{-- Language Switcher --}}
                <a href="{{ route('lang.switch', app()->getLocale() === 'sw' ? 'en' : 'sw') }}" class="action-btn" aria-label="Switch Language" title="{{ app()->getLocale() === 'sw' ? 'Switch to English' : 'Badili Kiswahili' }}">
                    <span class="lang-text">{{ app()->getLocale() === 'sw' ? 'SW' : 'EN' }}</span>
                </a>

                @guest
                    <div class="auth-group">
                        <a href="{{ route('login') }}" class="btn-ghost">{{ __('Login') }}</a>
                        <a href="{{ route('register') }}" class="btn-cta">{{ __('Register') }}</a>
                    </div>
                @else
                    {{-- Notifications --}}
                    <button class="action-btn" aria-label="Notifications" title="Notifications">
                        <i class="fa-regular fa-bell"></i>
                        <span class="badge-dot"></span>
                    </button>

                    {{-- Premium Profile Dropdown --}}
                    <div class="nav-item-profile" style="position:relative;">
                        <button class="profile-toggle">
                            <div class="profile-avatar">
                                {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                            </div>
                            <span class="profile-name">{{ auth()->user()->first_name }}</span>
                            <i class="fa-solid fa-chevron-down" style="font-size:10px; color:var(--text-muted);"></i>
                        </button>

                        <div class="profile-dropdown-menu">
                            <div class="profile-dropdown-header">
                                <div class="profile-header-avatar">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <div class="profile-header-info">
                                    <h5>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h5>
                                    <p>{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                            
                            @if(auth()->user()->role === 'agent')
                                <a href="{{ route('agent.dashboard') }}" class="profile-dropdown-link">
                                    <i class="fa-solid fa-gauge"></i> {{ __('Dashboard') }}
                                </a>
                            @elseif(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="profile-dropdown-link">
                                    <i class="fa-solid fa-shield-halved"></i> {{ __('Admin Panel') }}
                                </a>
                            @else
                                <a href="{{ route('user.dashboard') }}" class="profile-dropdown-link">
                                    <i class="fa-solid fa-gauge"></i> {{ __('Dashboard') }}
                                </a>
                            @endif

                            <a href="{{ route('profile') }}" class="profile-dropdown-link">
                                <i class="fa-solid fa-circle-user"></i> {{ __('My Profile') }}
                            </a>
                            <a href="{{ route('favorites.index') }}" class="profile-dropdown-link">
                                <i class="fa-solid fa-heart"></i> {{ __('Saved Properties') }}
                            </a>
                            <a href="{{ route('appointments.index') }}" class="profile-dropdown-link">
                                <i class="fa-solid fa-calendar-check"></i> {{ __('My Bookings') }}
                            </a>
                            <a href="{{ route('messages.index') }}" class="profile-dropdown-link">
                                <i class="fa-solid fa-envelope"></i> {{ __('Messages') }}
                            </a>
                            <a href="{{ route('profile') }}" class="profile-dropdown-link">
                                <i class="fa-solid fa-gear"></i> {{ __('Settings') }}
                            </a>

                            <div style="height:1px; background:var(--border,#ebebeb); margin:8px 0;"></div>

                            <a href="{{ route('profile') }}#delete-account" class="profile-dropdown-link text-danger">
                                <i class="fa-solid fa-trash"></i> {{ __('Delete Account') }}
                            </a>

                            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                                @csrf
                                <button type="submit" class="profile-dropdown-link btn-logout-dropdown text-danger">
                                    <i class="fa-solid fa-right-from-bracket"></i> {{ __('Logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </nav>
    </div>
</header>

{{-- Mobile Navigation Drawer --}}
<div class="mobile-drawer" id="mobileDrawer">
    <div class="drawer-header">
        <a href="{{ route('home') }}" class="nav-brand">
            <div class="brand-logo" style="width:32px;height:32px;">
                <img src="{{ asset('images/nyumbahublogo.png') }}" alt="Logo">
            </div>
            <span class="brand-name" style="font-size:18px;">{{ __('Nyumba') }}<span>{{ __('Hub') }}</span></span>
        </a>
        <button class="btn-close-drawer" id="closeDrawerBtn"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <div class="drawer-body">
        <ul class="drawer-nav-list">
            <li>
                <a href="{{ route('home') }}" class="drawer-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <div class="drawer-nav-link-content"><i class="fa-solid fa-home"></i> {{ __('Home') }}</div>
                </a>
            </li>
            
            {{-- Mobile Properties Accordion --}}
            <li class="drawer-accordion">
                <a href="javascript:void(0)" class="drawer-nav-link">
                    <div class="drawer-nav-link-content"><i class="fa-solid fa-building"></i> {{ __('Properties') }}</div>
                    <i class="fa-solid fa-chevron-down" style="font-size:12px; transition:transform 0.3s;"></i>
                </a>
                <div class="drawer-accordion-content">
                    <a href="{{ route('listings.index') }}" class="drawer-sub-link"><i class="fa-solid fa-layer-group"></i> {{ __('All Properties') }}</a>
                    <a href="{{ route('listings.index', ['type' => 'sale']) }}" class="drawer-sub-link"><i class="fa-solid fa-tag"></i> {{ __('For Sale') }}</a>
                    <a href="{{ route('listings.index', ['type' => 'rent']) }}" class="drawer-sub-link"><i class="fa-solid fa-key"></i> {{ __('For Rent') }}</a>
                    <a href="{{ route('listings.index', ['category' => 'apartment']) }}" class="drawer-sub-link"><i class="fa-solid fa-building"></i> {{ __('Apartments') }}</a>
                    <a href="{{ route('listings.index', ['category' => 'villa']) }}" class="drawer-sub-link"><i class="fa-solid fa-house"></i> {{ __('Houses') }}</a>
                    <a href="{{ route('listings.index', ['category' => 'commercial']) }}" class="drawer-sub-link"><i class="fa-solid fa-city"></i> {{ __('Commercial') }}</a>
                    <a href="{{ route('listings.index', ['category' => 'land']) }}" class="drawer-sub-link"><i class="fa-solid fa-map-location-dot"></i> {{ __('Land') }}</a>
                </div>
            </li>

            <li>
                <a href="{{ route('services') }}" class="drawer-nav-link {{ request()->routeIs('services') ? 'active' : '' }}">
                    <div class="drawer-nav-link-content"><i class="fa-solid fa-handshake"></i> {{ __('Services') }}</div>
                </a>
            </li>
            <li>
                <a href="{{ route('about') }}" class="drawer-nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                    <div class="drawer-nav-link-content"><i class="fa-solid fa-circle-info"></i> {{ __('About Us') }}</div>
                </a>
            </li>
            <li>
                <a href="{{ route('become-agent') }}" class="drawer-nav-link" style="color:var(--nav-primary);">
                    <div class="drawer-nav-link-content"><i class="fa-solid fa-briefcase"></i> {{ __('Become an Agent') }}</div>
                </a>
            </li>
            <li>
                <a href="{{ route('contact') }}" class="drawer-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                    <div class="drawer-nav-link-content"><i class="fa-solid fa-envelope"></i> {{ __('Contact') }}</div>
                </a>
            </li>
        </ul>
    </div>

    <div class="drawer-footer">
        @guest
            <div style="display:flex; gap:12px; margin-bottom: 16px;">
                <a href="{{ route('login') }}" class="btn-ghost" style="flex:1; text-align:center; border:1px solid var(--border,#ebebeb);">{{ __('Login') }}</a>
                <a href="{{ route('register') }}" class="btn-cta" style="flex:1; justify-content:center;">{{ __('Register') }}</a>
            </div>
        @else
            <div class="mobile-user-card" style="display:flex; align-items:center; gap:12px; padding:12px; background:var(--bg-soft,#f7f7f7); border-radius:12px; margin-bottom:16px;">
                <div class="profile-avatar">{{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}</div>
                <div style="flex:1;">
                    <div style="font-weight:700; font-size:14px; color:var(--nav-text);">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                    <div style="font-size:12px; color:var(--text-muted,#888);">{{ auth()->user()->email }}</div>
                </div>
            </div>
            
            <div class="drawer-nav-list" style="margin-bottom:16px;">
                @if(auth()->user()->role === 'agent')
                    <a href="{{ route('agent.dashboard') }}" class="drawer-sub-link"><i class="fa-solid fa-gauge"></i> {{ __('Dashboard') }}</a>
                @elseif(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="drawer-sub-link"><i class="fa-solid fa-shield-halved"></i> {{ __('Admin Panel') }}</a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="drawer-sub-link"><i class="fa-solid fa-gauge"></i> {{ __('Dashboard') }}</a>
                @endif
                <a href="{{ route('profile') }}" class="drawer-sub-link"><i class="fa-solid fa-user"></i> {{ __('My Profile') }}</a>
                <a href="{{ route('favorites.index') }}" class="drawer-sub-link"><i class="fa-solid fa-heart"></i> {{ __('Saved Properties') }}</a>
                <a href="{{ route('appointments.index') }}" class="drawer-sub-link"><i class="fa-solid fa-calendar"></i> {{ __('My Bookings') }}</a>
                <a href="{{ route('messages.index') }}" class="drawer-sub-link"><i class="fa-solid fa-envelope"></i> {{ __('Messages') }}</a>
                
                <form method="POST" action="{{ route('logout') }}" style="margin-top:8px;">
                    @csrf
                    <button type="submit" class="drawer-sub-link" style="width:100%; border:none; background:transparent; color:#ef4444; cursor:pointer;">
                        <i class="fa-solid fa-right-from-bracket" style="color:#ef4444;"></i> {{ __('Logout') }}
                    </button>
                </form>
            </div>
        @endguest

        <a href="{{ route('lang.switch', app()->getLocale() === 'sw' ? 'en' : 'sw') }}" class="drawer-nav-link" style="background:var(--bg-soft,#f7f7f7);">
            <div class="drawer-nav-link-content">
                <i class="fa-solid fa-globe" style="color:var(--nav-text);"></i> 
                <span style="font-size:14px;">{{ app()->getLocale() === 'sw' ? 'Switch to English' : 'Badili Kiswahili' }}</span>
            </div>
        </a>
    </div>
</div>
<div class="mobile-overlay" id="drawerOverlay"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Sticky Header
    const header = document.getElementById('siteHeader');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            header.classList.add('header-scrolled');
        } else {
            header.classList.remove('header-scrolled');
        }
    });

    // 2. Expandable Search
    const searchWrapper = document.getElementById('navSearchWrapper');
    const searchTriggerBtn = document.getElementById('searchTriggerBtn');
    const searchInput = searchWrapper.querySelector('.search-input');
    
    searchTriggerBtn.addEventListener('click', function(e) {
        if(!searchWrapper.classList.contains('active')) {
            e.preventDefault();
            searchWrapper.classList.add('active');
            setTimeout(() => searchInput.focus(), 100);
        } else if(searchInput.value.trim() === '') {
            e.preventDefault();
            searchWrapper.classList.remove('active');
        }
    });

    // Close search when clicking outside
    document.addEventListener('click', function(e) {
        if (searchWrapper.classList.contains('active') && !searchWrapper.contains(e.target)) {
            if(searchInput.value.trim() === '') {
                searchWrapper.classList.remove('active');
            }
        }
    });

    // 3. Mobile Drawer
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileDrawer = document.getElementById('mobileDrawer');
    const drawerOverlay = document.getElementById('drawerOverlay');
    const closeDrawerBtn = document.getElementById('closeDrawerBtn');

    function openDrawer() {
        mobileDrawer.classList.add('active');
        drawerOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        mobileDrawer.classList.remove('active');
        drawerOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    mobileMenuBtn.addEventListener('click', openDrawer);
    closeDrawerBtn.addEventListener('click', closeDrawer);
    drawerOverlay.addEventListener('click', closeDrawer);

    // 4. Mobile Drawer Accordion
    const accordions = document.querySelectorAll('.drawer-accordion > a');
    accordions.forEach(acc => {
        acc.addEventListener('click', function(e) {
            e.preventDefault();
            this.parentElement.classList.toggle('active');
        });
    });
});
</script>
