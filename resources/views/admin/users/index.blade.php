@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">User Accounts</h1>

    <div class="row">
        @foreach ($users as $user)
        @if ($user->id !== auth()->id()) 
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm text-center mb-4">
                <div class="card-body">
                    <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #ddd;">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="text-muted mb-1"><i class="fas fa-envelope"></i> {{ $user->email }}</p>
                    <p class="mb-1">
                        <i class="fas fa-user"></i> User Type:
                        <span class="{{ $user->user_type === 'admin' ? 'text-warning fw-bold' : 'fw-normal' }}">
                            {{ ucfirst($user->user_type) }}
                        </span>
                    </p>
                    <p class="mb-1">User Created:</p><span>{{date_format($user->created_at,'Y-M-d h:i')  }}</span>

                    <form action="{{ route('admin.users.destroy',$user->id) }}" method="POST" class="m-0 p-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this user?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @endforeach

        @if($users->where('id', '!=', auth()->id())->isEmpty())
        <div class="col-12">
            <div class="alert alert-warning text-center">
                <i class="fas fa-exclamation-circle"></i> No other user accounts found!
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
