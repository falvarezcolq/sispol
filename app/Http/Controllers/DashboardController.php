<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();
        return Inertia::render('Dashboard', [
            'user' => $user,
            'cards' => $user->cards()->orderByDesc('id')->get(),
            'serverTime' => now()->format('d/m/Y H:i:s'),
        ]);
    }
}
