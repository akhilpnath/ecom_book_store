@extends('layouts.admin')

@section('content')
<section class="user-accounts">
    <h1 class="title">User Accounts</h1>
    <div class="box-container">
        @foreach ($users as $user)
        <div class="box" style="{{ $user->id === auth()->id() ? 'display:none;' : '' }}">
            <img src="{{ asset('uploaded_img/' . $user->image) }}" alt="">
            <p>User ID: <span>{{ $user->id }}</span></p>
            <p>Username: <span>{{ $user->name }}</span></p>
            <p>Email: <span>{{ $user->email }}</span></p>
            <p>User Type: <span style="color: {{ $user->user_type === 'admin' ? 'orange' : 'inherit' }}">{{ $user->user_type }}</span></p>
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn" onclick="return confirm('Delete this user?')">Delete</button>
            </form>
        </div>
        @endforeach
    </div>
</section>
@endsection