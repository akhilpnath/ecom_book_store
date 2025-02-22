@extends('layouts.app')

@section('content')
<section class="form-container">
    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h3>Register Now</h3>
        <input type="text" name="name" class="box" placeholder="Enter your name" required>
        <input type="email" name="email" class="box" placeholder="Enter your email" required>
        <input type="password" name="password" class="box" placeholder="Enter your password" required>
        <input type="password" name="password_confirmation" class="box" placeholder="Confirm your password" required>
        <input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png">
        <button type="submit" class="btn">Register Now</button>
        <p>Already have an account? <a href="{{ route('login') }}">Login Now</a></p>
    </form>
</section>
@endsection