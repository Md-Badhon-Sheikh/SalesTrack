<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chatWith($receiver_id)
    {
        $receiver = User::findOrFail($receiver_id);
        $currentUser = Auth::user();

        

        return view('backend.common.chat', compact('receiver', 'currentUser'));
    }
}
