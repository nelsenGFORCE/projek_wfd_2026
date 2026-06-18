<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudioRequest;
use App\Models\Seat;
use App\Models\Studio;
use Illuminate\Http\Request;

class AdminStudioController extends Controller
{
    public function index()
    {
        $studios = Studio::with('seats')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.studios.index', compact('studios'));
    }

    public function create()
    {
        return view('admin.studios.create');
    }

    public function store(StudioRequest $request)
    {
        $data = $request->validated();

        $studio = Studio::create($data);

        $this->generateSeats($studio);

        return redirect()->route('admin.studios.index')
            ->with('success', 'Studio created successfully with seats.');
    }

    public function show(Studio $studio)
    {
        $studio->load('seats');
        return view('admin.studios.show', compact('studio'));
    }

    public function edit(Studio $studio)
    {
        return view('admin.studios.edit', compact('studio'));
    }

    public function update(StudioRequest $request, Studio $studio)
    {
        $data = $request->validated();

        $studio->update($data);

        if ($studio->wasChanged('capacity')) {
            $studio->seats()->delete();
            $this->generateSeats($studio);
        }

        return redirect()->route('admin.studios.index')
            ->with('success', 'Studio updated successfully.');
    }

    public function destroy(Studio $studio)
    {
        $studio->seats()->delete();
        $studio->delete();

        return redirect()->route('admin.studios.index')
            ->with('success', 'Studio deleted successfully.');
    }

    private function generateSeats(Studio $studio): void
    {
        $rows = range('A', 'J');
        $seatsPerRow = (int) floor($studio->capacity / count($rows));
        $remainder = $studio->capacity % count($rows);

        foreach ($rows as $index => $row) {
            $count = $seatsPerRow + ($index < $remainder ? 1 : 0);

            if ($count === 0) {
                break;
            }

            for ($col = 1; $col <= $count; $col++) {
                $seatNumber = $row . $col;
                Seat::create([
                    'studio_id' => $studio->id,
                    'seat_number' => $seatNumber,
                ]);
            }
        }
    }
}