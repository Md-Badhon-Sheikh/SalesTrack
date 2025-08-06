<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class AdminChatController extends Controller implements HasMiddleware
{
    
      public static function middleware(): array
  {
    return [
      BackendAuthenticationMiddleware::class,
      AdminAuthenticationMiddleware::class
    ];
  }

     public function index()
    {
        $currentUser = Auth::user();

        if ($currentUser->user_type !== 'admin') {
            abort(403);
        }

        $users = User::where('user_type', '!=', 'admin')->get();

        return view('backend.admin.pages.chat', compact('currentUser', 'users'))->with('isAdmin', true);


    }
}
