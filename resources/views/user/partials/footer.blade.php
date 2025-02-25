<footer class="footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <h5 class="mb-4">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li><a href="{{ route('user.shop') }}">Shop</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="{{ route('user.contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="mb-4">Extra Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('user.cart') }}">Cart</a></li>
                    <li><a href="{{ route('user.wishlist') }}">Wishlist</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="mb-4">Contact Info</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-phone me-2"></i>+91 8301063455
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-envelope me-2"></i>akhilsby789@gmail.com
                    </li>
                    <li>
                        <i class="fas fa-map-marker-alt me-2"></i>Kerala, India - 400104
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="mb-4">Follow Us</h5>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <div class="mt-4">
                    <h6 class="mb-3">Subscribe to our newsletter</h6>
                    <form class="d-flex">
                        <input type="email" class="form-control" placeholder="Enter email">
                        <button type="submit" class="btn btn-primary ms-2">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="border-top mt-5 pt-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} BookStore. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="footer-payment">
                        <i class="fab fa-cc-visa me-2"></i>
                        <i class="fab fa-cc-mastercard me-2"></i>
                        <i class="fab fa-cc-paypal me-2"></i>
                        <i class="fab fa-cc-amex"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>