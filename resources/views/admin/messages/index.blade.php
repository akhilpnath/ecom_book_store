@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Messages</h1>

    <div class="row">
        @forelse ($messages as $message)
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-user"></i> {{ $message->name }}</h5>
                    <p class="text-muted mb-1"><i class="fas fa-id-badge"></i> User ID: <strong>{{ $message->user_id }}</strong></p>
                    <p class="text-muted mb-1"><i class="fas fa-phone"></i> Number: <strong>{{ $message->number }}</strong></p>
                    <p class="text-muted mb-1"><i class="fas fa-envelope"></i> Email: <strong>{{ $message->email }}</strong></p>
                    <p class="text-muted mb-2"><i class="fas fa-comment"></i> Message:</p>
                    <div class="alert alert-light border p-2">{{ $message->message }}</div>

                    <form action="{{ route('messages.destroy', $message->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this message?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">
                <i class="fas fa-exclamation-circle"></i> You have no messages!
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
