<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin_style.css') }}">
</head>
<body>
    <header class="header">
        <div class="flex">
            <a href="{{ route('admin.dashboard') }}" class="logo">Admin<span>Panel</span></a>
            <nav class="navbar">
                <a href="{{ route('admin.dashboard') }}">Home</a>
                <a href="{{ route('admin.products.index') }}">Products</a>
                <a href="{{ route('admin.orders.index') }}">Orders</a>
                <a href="{{ route('admin.users.index') }}">Users</a>
                <a href="{{ route('admin.messages.index') }}">Messages</a>
            </nav>
            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div>
                <div id="user-btn" class="fas fa-user"></div>
            </div>
            <div class="profile">
                <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="{{ Auth::user()->name }}">
                <p>{{ Auth::user()->name }}</p>
                <a href="{{ route('admin.profile.edit') }}" class="btn">Update Profile</a>
                <a href="{{ route('logout') }}" class="delete-btn">Logout</a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>