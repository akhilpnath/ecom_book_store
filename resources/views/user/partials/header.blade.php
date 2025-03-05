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
                        <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button"
                            id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="{{ Auth::user()->name }}"
                                class="rounded-circle me-2" style="width: 35px; height: 35px; object-fit: cover;">
                            <span>{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-edit me-2"></i> Update Profile
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary ms-3">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>