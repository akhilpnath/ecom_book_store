<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookStore - @yield('title', 'Online Book Shop')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --text-light: #95a5a6;
        }

        .hero-section {
            background: linear-gradient(rgba(44, 62, 80, 0.9), rgba(44, 62, 80, 0.9)),
                url('/images/books-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 8rem 0;
            color: white;
        }

        .category-card {
            transition: transform 0.3s ease;
            border: none;
            border-radius: 1rem;
            overflow: hidden;
        }

        .category-card:hover {
            transform: translateY(-10px);
        }

        .category-card img {
            height: 200px;
            object-fit: cover;
        }

        .product-card {
            border: none;
            border-radius: 1rem;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .product-card img {
            height: 250px;
            object-fit: contain;
            padding: 1rem;
        }

        .navbar-nav .nav-link {
            color: var(--primary-color);
            font-weight: 500;
            padding: 0.5rem 1rem;
        }

        .navbar-nav .nav-link:hover {
            color: var(--accent-color);
        }

        .cart-icon,
        .wishlist-icon {
            position: relative;
            color: var(--primary-color);
            font-size: 1.2rem;
            margin: 0 0.5rem;
        }

        .cart-icon span,
        .wishlist-icon span {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--accent-color);
            color: white;
            border-radius: 50%;
            padding: 0.2rem 0.5rem;
            font-size: 0.75rem;
        }

        .user-profile-dropdown {
            min-width: 200px;
            padding: 0.5rem;
        }

        .user-profile-dropdown img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        footer {
            background: var(--primary-color);
            color: white;
            padding: 4rem 0 2rem;
        }

        footer a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: var(--accent-color);
        }

        .social-links a {
            display: inline-block;
            width: 35px;
            height: 35px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 35px;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--accent-color);
            transform: translateY(-3px);
        }

        .category-slider {
            overflow: hidden;
            white-space: nowrap;
            position: relative;
            width: 100%;
        }

        .category-track {
            display: flex;
            gap: 20px;
            width: max-content;
            position: relative;
            animation: scroll 20s linear infinite;
        }

        .category-item {
            flex: 0 0 auto;
            width: 250px;

        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }
    </style>
</head>

<body>
    @include('user.partials.header')
    <main>
        @yield('content')
    </main>
    @include('user.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>


