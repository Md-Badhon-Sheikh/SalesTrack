<?php

namespace App\Http\Controllers\Backend\Salesman;

use App\Http\Controllers\Controller;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use App\Http\Middleware\SalesmanAuthenticationMiddleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class SalesmanChatController extends Controller implements HasMiddleware
{


      public static function middleware(): array
    {
        return [
            BackendAuthenticationMiddleware::class,
            SalesmanAuthenticationMiddleware::class
        ];
    }

    public function index()
    {
        $currentUser = Auth::user();

        if ($currentUser->user_type === 'admin') {
            abort(403);
        }

        return view('backend.salesman.pages.chat', compact('currentUser'));
    }
}
