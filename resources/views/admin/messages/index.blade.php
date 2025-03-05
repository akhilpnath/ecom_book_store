@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="display-6 fw-bold">
                <i class="text-primary me-3"></i>Customer Messages
            </h2>
        </div>
        <div class="col-auto">
            <span class="badge bg-info-subtle text-info p-2">
                Total Messages: {{ $messages->count() }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fa-2x me-3 text-success"></i>
                <div>
                    {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse ($messages as $message)
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 border-0 shadow-lg hover-lift">
                    <div class="card-header {{ $message->is_read ? 'bg-success-subtle' : 'bg-primary-subtle' }} border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-circle me-2 text-muted"></i>
                                {{ Str::limit($message->name, 20) }}
                            </h5>
                            @if(!$message->is_read)
                                <span class="badge bg-danger text-white">New</span>
                            @else
                                <span class="badge bg-success text-white">Read</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">
                                <i class="fas fa-envelope me-2"></i>{{ $message->email }}
                            </small>
                            <small class="text-muted d-block mb-1">
                                <i class="fas fa-phone me-2"></i>{{ $message->number }}
                            </small>
                            <small class="text-muted d-block">
                                <i class="fas fa-id-badge me-2"></i>User ID: {{ $message->user_id }}
                            </small>
                        </div>
                        
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body py-2 px-3">
                                <p class="card-text text-muted fst-italic">
                                    "{{ Str::limit($message->message, 100) }}"
                                </p>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            @if(!$message->is_read)
                                <form action="{{ route('admin.messages.markRead', $message->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-success w-100">
                                        <i class="fas fa-check-circle me-2"></i>Mark as Read
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100" 
                                    onclick="return confirm('Are you sure you want to delete this message?')">
                                    <i class="fas fa-trash me-2"></i>Delete Message
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-muted">
                            <i class="fas fa-clock me-2"></i>
                            {{ $message->created_at->diffForHumans() }}
                        </small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light text-center p-5 shadow-sm">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h4 class="alert-heading">No Messages</h4>
                    <p class="mb-0">You have no new customer messages at the moment.</p>
                </div>
            </div>
        @endforelse
    </div>

    @if($messages->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $messages->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection