<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the administrasi dashboard.
     */
    public function index()
    {
        // For now, redirect to Role Management as it's the main feature here
        return redirect()->route('administrasi.roles.index');
    }
}
