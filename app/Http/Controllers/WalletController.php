<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WalletController extends Controller
{
    public function show(Request $request): Response
    {
        $wallet = $request->user()
            ->wallet()
            ->first();

        return Inertia::render('Wallet/Show', [
            'wallet' => $wallet,
        ]);
    }
}