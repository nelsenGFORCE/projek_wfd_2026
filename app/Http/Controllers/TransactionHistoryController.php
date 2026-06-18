<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class TransactionHistoryController extends Controller
{
    public function index()
    {
        $transactions = Auth::user()
            ->transactions()
            ->with(['schedule.movie', 'schedule.studio', 'transactionDetails.seat'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }
}