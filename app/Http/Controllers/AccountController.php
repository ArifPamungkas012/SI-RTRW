<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Apply auth middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        $user = Auth::user()->load('warga');
        return view('account.profile', compact('user'));
    }

    public function settings()
    {
        $user = Auth::user()->load('warga');
        return view('account.settings', compact('user'));
    }

    public function meJson()
    {
        $user = Auth::user()->load('warga');
        return response()->json($user);
    }
}
