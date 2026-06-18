<?php

namespace App\Http\Controllers;

use App\Enums\MovieStatus;
use App\Models\Movie;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $genre = $request->input('genre');

        $nowShowing = Movie::where('status', MovieStatus::NowShowing->value)
            ->with(['schedules' => function ($query) {
                $query->where('show_date', '>=', now()->toDateString())
                    ->orderBy('show_date')
                    ->orderBy('start_time');
            }, 'schedules.studio'])
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($genre, fn($q) => $q->where('genre', $genre))
            ->latest()
            ->get();

        $comingSoon = Movie::where('status', MovieStatus::ComingSoon->value)
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($genre, fn($q) => $q->where('genre', $genre))
            ->latest()
            ->get();

        $genres = Movie::select('genre')->distinct()->pluck('genre');

        return view('home', compact('nowShowing', 'comingSoon', 'genres', 'search', 'genre'));
    }
}
