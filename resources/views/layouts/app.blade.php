<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

         <title>@yield('title', 'NyumbaHub')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>

{{--NAVBAR--}}
<nav class="navbar">
    <div class="nav-container">
        <a href="{{ url('/')}}" class="nav-brand">
            Nyumba<span>Hub</span>
        </a>

        <div class="nav-links">
            <a href="{{route('listings.index')}}" class="nav-link">
                <i class="fa-solid fa-building"></i>Listings
            </a>

            @auth
            {{--ROLE BASED NAVIGATION--}}
          @if(auth()->user()->role === 'agent')

            <a href="{{ route('agent.dashboard')}}" class="nav-link">
                <i class="fa-solid fa-guage"></i> Dashboard
            </a>

            <a href="{{ route('agent.listings.create')}}" class="nav-link">
                <i class="fa-solid fa-plus"></i>Add Listing
            </a>

            @elseif (auth()->user()->role==='tenant')

            <a href="{{ route('tenant.dashboard')}}" class="nav-link">
                <i class="fa-solid fa-guage"></i>Dashboard
            </a>
            @endif

 {{--USER DROPDOWN--}}
 <div  class="nav-dropdown">
    <button class="nav-dropdown-btn">
        <i class="fa-solid fa-circle-user"></i>

        {{ auth()->user()->first_name}}

        <i class="fa-solid fa-chevron-down" style="font-size:10px;"></i>
    </button>

    <div class="nav-dropdown-menu">
        <a href="#" class="dropdown-item">
            <i class="fa-solid fa-user"></i>Profile
        </a>

        <div class="dropdown-divider"></div>
        <form method="POST" action="{{ route('logout')}}">

          @csrf
          <button type="submit" class="dropdown-item dropdown-item-danger">
            <i class="fa-solid fa-right-from-bracket"></i>  Logout
          </button>
        </form>
    </div>
 </div>

 @else
 <a href="{{ route('login')}}" class="nav-link">Login</a>

 <a href="{{ route('register')}}" class="btn-nav">Register</a>
 @endauth
</div>

{{-- MOBILE MENU TOGGLE--}}
<button class="nav-toggle" onclick="toggleMenu()">
    <i class="fa-solid fa-bars"></i>
</button>
    </div>

    {{--MOBILE MENU--}}
    <button class="nav-mobile" id="mobileMenu">
        <a href="{{ route('listings.index')}}" class="nav-mobile-link">Listings</a>

        @auth
            <a href="#" class="nav-mobile-link">Dashboard</a>
            <form method="POST" action="{{ route('logout')}}">

                @csrf
                <button type="submit" class="nav-mobile-link nav-mobile-logout">
                    <i class="fa-solid fa-right-from-bracket"></i>Logout
                </button>
            </form>

         @else
         <a href="{{ route('login')}}" class="nav-mobile-link">Login</a>

         <a href="{{ route('register')}}" class="nav-mobile-link">Register</a>
        @endauth
        </div>
    </nav>

    {{--MAIN CONTENT--}}
    <main class="main-content">

        {{--Flash messages--}}
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i>

            {{ session('error')}}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">
            <i class=fa-solid fa-circle-exclamation></i>
            {{session('error')}}
        </div>
        @endif

        @yield('content')
    </main>

    {{--FOOTER--}}
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-brand">
                <span class="brand-name">Nyumba<span>Hub</span></span>
                <p>Your Next Home, Found.</p>
            </div>

            <div class="footer-links">
                <a href="#">About</a>
                <a href="#">Contact</a>
                <a href="#">Privacy Policy</a>
            </div>

            <p class="footer-copy">&copy; {{ date('Y')}} NyumbaHub. Arusha, Tanzania.</p>
        </div>
    </footer>

    <script>
        //DROPDOWN TOGGLE
        document.querySelectorAll('.nav-dropdown-btn').forEach(btn =>{
            btn.addEventListener('click', () => {
                btn.nextElementSibling.classList.toggle('show');
            });
        });

        //Close dropdown when clicking outside
        document.addEventListener('click', e =>{
            if (!e.target.closest('.nav-dropdown')) {
                document.querySelectorAll('.nav-dropdown-menu').forEach(m => m.classList.remove('show'));
            }
        });

        //Mobile Menu
        function toggleMenu() {
            document.getElementById('mobileMenu').classList.toggle('show');
        }
    </script>

    @stack('scripts')
</body>
</html>





