@extends('backend.salesman.includes.salesman_layout')

@section('content')
@include('backend.salesman.includes.firebase_script')
<div class="container py-4">
    <h2 class="mb-4">💬 Chat with Admin</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="bi bi-person-circle"></i> {{ $currentUser->name }} (You)</span>
            <span><i class="bi bi-person-fill-lock"></i> Admin</span>
        </div>

        <div class="card-body" id="chatWindow" style="height: 400px; overflow-y: auto; background: #f8f9fa;">
            {{-- Messages will appear here --}}
        </div>

        <div class="card-footer">
            <div class="input-group">
                <input type="text" id="messageInput" class="form-control" placeholder="Type your message...">
                <button class="btn btn-success" onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@include('backend.salesman.includes.firebase_script', [
    'isAdmin' => false, 
    'receiverId' => 1
    ]);
@endsection
