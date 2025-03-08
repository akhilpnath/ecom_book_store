@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="m-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
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