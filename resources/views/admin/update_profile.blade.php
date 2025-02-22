@extends('layouts.admin')

@section('content')
<section class="update-profile">
    <h1 class="title">Update Profile</h1>

    @if(session('success'))
        <div class="message">
            <span>{{ session('success') }}</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
    @endif

    @if($errors->any())
        <div class="message">
            @foreach($errors->all() as $error)
                <span>{{ $error }}</span>
            @endforeach
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="{{ Auth::user()->name }}">
        <div class="flex">
            <div class="inputBox">
                <span>Username:</span>
                <input type="text" name="name" value="{{ Auth::user()->name }}" placeholder="Update username" required class="box">
                <span>Email:</span>
                <input type="email" name="email" value="{{ Auth::user()->email }}" placeholder="Update email" required class="box">
                <span>Update Picture:</span>
                <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
                <input type="hidden" name="old_image" value="{{ Auth::user()->image }}">
            </div>
            <div class="inputBox">
                <input type="hidden" name="old_pass" value="{{ Auth::user()->password }}">
                <span>Old Password:</span>
                <input type="password" name="update_pass" placeholder="Enter previous password" class="box">
                <span>New Password:</span>
                <input type="password" name="new_pass" placeholder="Enter new password" class="box">
                <span>Confirm Password:</span>
                <input type="password" name="confirm_pass" placeholder="Confirm new password" class="box">
            </div>
        </div>
        <div class="flex-btn">
            <button type="submit" class="btn" name="update_profile">Update Profile</button>
            <a href="{{ route('admin.dashboard') }}" class="option-btn">Go Back</a>
        </div>
    </form>
</section>
@endsection