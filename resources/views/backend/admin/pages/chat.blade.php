@extends('backend.admin.includes.admin_layout')

@section('content')


<div class="container py-4">
    <h2 class="mb-4"> Admin Chat Panel</h2>

    <div class="row">
        <!-- User List -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <strong>Users</strong>
                </div>
                <ul class="list-group list-group-flush" id="userList">
                    @foreach($users as $user)
                        <li class="list-group-item list-group-item-action"
                            style="cursor: pointer"
                            onclick="startChat('{{ $user->id }}', '{{ $user->name }}')">
                            <i class="bi bi-person-fill"></i> {{ $user->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Chat Window -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <strong>Chat with: <span id="chatWith">[Select a user]</span></strong>
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
    </div>
</div>
@endsection

@section('scripts')
@include('backend.admin.includes.firebase_script',[
    'currentUser' => $currentUser,
    'isAdmin' => true
    ])
@endsection

