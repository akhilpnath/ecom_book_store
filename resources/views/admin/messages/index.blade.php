@extends('layouts.admin')

@section('content')
<section class="messages">
    <h1 class="title">Messages</h1>
    <div class="box-container">
        @forelse ($messages as $message)
        <div class="box">
            <p>User ID: <span>{{ $message->user_id }}</span></p>
            <p>Name: <span>{{ $message->name }}</span></p>
            <p>Number: <span>{{ $message->number }}</span></p>
            <p>Email: <span>{{ $message->email }}</span></p>
            <p>Message: <span>{{ $message->message }}</span></p>
            <form action="{{ route('messages.destroy', $message->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn" onclick="return confirm('Delete this message?')">Delete</button>
            </form>
        </div>
        @empty
        <p class="empty">you have no messages!</p>
        @endforelse
    </div>
</section>
@endsection