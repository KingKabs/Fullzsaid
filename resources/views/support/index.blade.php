@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Support Chat</h3>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div id="chat-box" class="card-body" style="height: 400px; overflow-y: auto; display: flex; flex-direction: column;">
            @forelse($messages as $msg)
            <div class="d-flex mb-2 {{ $msg->sender == 'user' ? 'justify-content-end' : 'justify-content-start' }}">
                <div class="p-2 rounded {{ $msg->sender == 'user' ? 'bg-primary text-white' : 'bg-light text-dark' }}" style="max-width: 70%;">
                    <strong>{{ $msg->sender == 'user' ? 'You' : 'Support' }}</strong>
                    <p class="mb-1">{{ $msg->message }}</p>
                    <small class="text-muted">{{ $msg->created_at->format('H:i, M d') }}</small>
                </div>
            </div>
            @empty
            <p class="text-muted text-center">No messages yet.</p>
            @endforelse
        </div>

        <div class="card-footer">
            <form action="{{ route('support.store') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="message" class="form-control" placeholder="Type your message..." required>
                    <button class="btn btn-primary" type="submit">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Auto scroll to bottom
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endsection
