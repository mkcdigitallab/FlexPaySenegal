<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TransactionController extends Controller
{
    public function index(Request $request): Response
    {
        $wallet = $request->user()
            ->wallet()
            ->first();

        if (! $wallet) {
            return Inertia::render('Transactions/Index', [
                'transactions' => [],
            ]);
        }

        $transactions = Transaction::query()
            ->where(function ($query) use ($wallet) {
                $query->where('wallet_id', $wallet->id)
                    ->orWhere('recipient_wallet_id', $wallet->id);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions,
        ]);
    }
}