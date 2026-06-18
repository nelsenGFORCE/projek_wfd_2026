<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    public function show(Movie $movie)
    {
        $movie->load(['schedules' => function ($query) {
            $query->where('show_date', '>=', now()->toDateString())
                ->orderBy('show_date')
                ->orderBy('start_time');
        }, 'schedules.studio']);

        $schedules = $movie->schedules->map(function ($schedule) {
            $bookedSeatIds = DB::table('transaction_details')
                ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
                ->where('transactions.schedule_id', $schedule->id)
                ->where('transactions.payment_status', '!=', 'failed')
                ->pluck('transaction_details.seat_id');

            $totalSeats = $schedule->studio->capacity;
            $availableSeats = $totalSeats - $bookedSeatIds->count();

            $schedule->available_seats = $availableSeats;
            $schedule->studio_name = $schedule->studio->studio_name;

            return $schedule;
        })->groupBy('show_date');

        return view('movies.show', compact('movie', 'schedules'));
    }
}
