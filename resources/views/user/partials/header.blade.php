<nav class="navbar navbar-expand-lg bg-white fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('user.home') }}">
            <i class="fas fa-book me-2"></i>BookStore
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.shop') }}">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.orders') }}">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.contact') }}">Contact</a>
                </li>
            </ul>
            
            <div class="d-flex align-items-center">
                <a href="{{ route('user.wishlist') }}" class="wishlist-icon">
                    <i class="fas fa-heart"></i>
                    <span>{{ Auth::check() ? Auth::user()->wishlistItems->count() : 0 }}</span>
                </a>
                <a href="{{ route('user.cart') }}" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span>{{ Auth::check() ? Auth::user()->cartItems->count() : 0 }}</span>
                </a>
                
                @auth
                    <div class="dropdown ms-3">
                        <button class="btn btn-link text-dark p-0" type="button" data-bs-toggle="dropdown">
                            <img src="{{ asset('storage/' . Auth::user()->image) }}" 
                                 alt="{{ Auth::user()->name }}"
                                 class="rounded-circle"
                                 width="40" height="40">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end user-profile-dropdown">
                            <div class="px-3 py-2">
                                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                <small class="text-muted">{{ Auth::user()->email }}</small>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user me-2"></i>Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary ms-3">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>