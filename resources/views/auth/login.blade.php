@extends('layouts.app')

@section('content')
    <section class="form-container">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <h3>Login Now</h3>
            <input type="email" name="email" class="box" placeholder="Enter your email" required>
            <input type="password" name="password" class="box" placeholder="Enter your password" required>

            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>

            <button type="submit" class="btn">Login Now</button>
            <p>Don't have an account? <a href="{{ route('register') }}">Register Now</a></p>
        </form>
    </section>
@endsection