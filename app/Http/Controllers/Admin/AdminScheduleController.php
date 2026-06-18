<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleRequest;
use App\Models\Movie;
use App\Models\Schedule;
use App\Models\Studio;
use Illuminate\Http\Request;

class AdminScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['movie', 'studio'])
            ->orderBy('show_date', 'desc')
            ->orderBy('start_time', 'asc')
            ->paginate(10);

        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $movies = Movie::where('status', 'now_showing')->orderBy('title')->get();
        $studios = Studio::orderBy('studio_name')->get();

        return view('admin.schedules.create', compact('movies', 'studios'));
    }

    public function store(ScheduleRequest $request)
    {
        Schedule::create($request->validated());

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule created successfully.');
    }

    public function show(Schedule $schedule)
    {
        $schedule->load(['movie', 'studio']);
        return view('admin.schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        $movies = Movie::where('status', 'now_showing')->orderBy('title')->get();
        $studios = Studio::orderBy('studio_name')->get();

        return view('admin.schedules.edit', compact('schedule', 'movies', 'studios'));
    }

    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        $schedule->update($request->validated());

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }
}