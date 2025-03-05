<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css">
    <link rel="stylesheet" href="{{ asset('css/admin_new_style.css') }}">
    @stack('styles')
</head>

<body>
    <header class="header d-flex align-items-center justify-content-between">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            Admin<span>Panel</span>
        </a>
        <div class="d-flex align-items-center gap-3">
            <div class="icons">
                <button class="d-md-none" id="menu-btn">
                    <i class="fas fa-bars"></i>
                </button>
                <a href="{{ route('admin.messages.index') }}"
                    class="notification-badge btn btn-light position-relative">
                    <i
                        class="fas fa-bell {{ \App\Models\Message::where('is_read', false)->count() > 0 ? 'text-danger' : '' }}"></i>
                    @php $unreadCount = \App\Models\Message::where('is_read', false)->count(); @endphp
                    @if($unreadCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>
            </div>
            <div class="dropdown">
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
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/products*') ? 'active' : '' }}"
                                href="{{ route('admin.products.index') }}">
                                <i class="fas fa-box"></i>
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/orders*') ? 'active' : '' }}"
                                href="{{ route('admin.orders.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                                Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}"
                                href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users"></i>
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/messages*') ? 'active' : '' }}"
                                href="{{ route('admin.messages.index') }}">
                                <i class="fas fa-envelope"></i>
                                Messages
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="profile-section">
                <div class="profile">
                    <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="{{ Auth::user()->name }}">
                    <p> {{ Auth::user()->name }}</p>
                </div>
            </div>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        $(document).ready(function () {
            $("#menu-btn").on("click", function () {
                $(".sidebar").toggleClass("show");
            });

            $(document).on("click", function (event) {
                if (!$(event.target).closest(".sidebar, #menu-btn").length) {
                    $(".sidebar").removeClass("show");
                }
            });

            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });

            $(document).on("click", function (event) {
                if (!$(event.target).closest(".dropdown").length) {
                    $(".dropdown-menu").removeClass("show");
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>