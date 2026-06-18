<?php

namespace App\Http\Controllers\Api;

use App\Enums\MovieStatus;
use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $genre = $request->input('genre');

        $movies = Movie::with(['schedules' => function ($query) {
            $query->where('show_date', '>=', now()->toDateString())
                ->orderBy('show_date')
                ->orderBy('start_time');
        }, 'schedules.studio'])
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($genre, fn($q) => $q->where('genre', $genre))
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data film',
            'data' => $movies,
        ]);
    }

    public function nowShowing(Request $request)
    {
        $search = $request->input('search');
        $genre = $request->input('genre');

        $movies = Movie::where('status', MovieStatus::NowShowing->value)
            ->with(['schedules' => function ($query) {
                $query->where('show_date', '>=', now()->toDateString())
                    ->orderBy('show_date')
                    ->orderBy('start_time');
            }, 'schedules.studio'])
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($genre, fn($q) => $q->where('genre', $genre))
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil film yang sedang tayang',
            'data' => $movies,
        ]);
    }

    public function comingSoon(Request $request)
    {
        $search = $request->input('search');
        $genre = $request->input('genre');

        $movies = Movie::where('status', MovieStatus::ComingSoon->value)
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($genre, fn($q) => $q->where('genre', $genre))
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil film yang segera tayang',
            'data' => $movies,
        ]);
    }

    public function show($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Film tidak ditemukan',
                'data' => null,
            ], 404);
        }

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

            return [
                'id' => $schedule->id,
                'show_date' => $schedule->show_date->format('Y-m-d'),
                'start_time' => $schedule->start_time,
                'ticket_price' => $schedule->ticket_price,
                'studio' => [
                    'id' => $schedule->studio->id,
                    'name' => $schedule->studio->studio_name,
                    'capacity' => $schedule->studio->capacity,
                ],
                'available_seats' => $availableSeats,
                'total_seats' => $totalSeats,
            ];
        })->groupBy('show_date');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil detail film',
            'data' => [
                'id' => $movie->id,
                'title' => $movie->title,
                'synopsis' => $movie->synopsis,
                'duration' => $movie->duration,
                'poster' => $movie->poster,
                'genre' => $movie->genre,
                'status' => $movie->status,
                'schedules' => $schedules,
            ],
        ]);
    }
}