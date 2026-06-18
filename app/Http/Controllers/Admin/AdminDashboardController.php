<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Schedule;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalMovies = Movie::count();
        $schedulesToday = Schedule::whereDate('show_date', today())->count();
        $totalTransactions = Transaction::count();
        $revenue = Transaction::where('payment_status', 'success')->sum('total_price');

        return view('admin.dashboard', compact(
            'totalMovies',
            'schedulesToday',
            'totalTransactions',
            'revenue'
        ));
    }
}