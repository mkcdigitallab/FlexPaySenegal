<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();

        $wallet = $user->wallet()
            ->first();

        $transactions = $wallet
            ? $wallet->transactions()
                ->latest()
                ->limit(5)
                ->get()
            : collect();

        return Inertia::render('Dashboard', [
            'user' => $user->only('id', 'name', 'phone', 'role'),
            'wallet' => $wallet,
            'transactions' => $transactions,
        ]);
    }
}