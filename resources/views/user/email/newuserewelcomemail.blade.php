<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to BookStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/useremail.css') }}">
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/bookstore-logo.png') }}" alt="BookStore Logo" class="logo">
            <h1>Welcome to BookStore!</h1>
        </div>

        <div class="welcome-banner">
            <h2>Hello, {{ $user->name }}!</h2>
            <p>Thank you for joining our community of book lovers.</p>
        </div>

        <div class="content">
            <p>We're excited to have you as part of our BookStore family. Your account has been successfully created and
                you can now enjoy the following benefits:</p>

            <ul class="list-group mb-4">
                <li class="list-group-item d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-check-circle-fill text-success me-2" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                    Access to thousands of books across various genres
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-check-circle-fill text-success me-2" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                    Exclusive member discounts and promotions
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-check-circle-fill text-success me-2" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                    Personalized book recommendations
                </li>
            </ul>

            <div class="text-center">
                <a href="{{ route('login') }}" class="btn-primary">Get Started Now</a>
            </div>

            <p class="mt-4">If you have any questions or need assistance, please don't hesitate to contact our customer
                support team at <a href="mailto:support@bookstore.com">support@bookstore.com</a>.</p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} BookStore. All rights reserved.</p>
            <p>This email was sent to {{ $user->email }}. If you did not create an account, please <a
                    href="{{ route('user.contact') }}">contact us</a>.</p>
            <div class="social-links mt-2">
                <a href="#" style="margin: 0 5px;"><img src="{{ asset('images/facebook-icon.png') }}" alt="Facebook"
                        width="24"></a>
                <a href="#" style="margin: 0 5px;"><img src="{{ asset('images/twitter-icon.png') }}" alt="Twitter"
                        width="24"></a>
                <a href="#" style="margin: 0 5px;"><img src="{{ asset('images/instagram-icon.png') }}" alt="Instagram"
                        width="24"></a>
            </div>
        </div>
    </div>
</body>

</html>