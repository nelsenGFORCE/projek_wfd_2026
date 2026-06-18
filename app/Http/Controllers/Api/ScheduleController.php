<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function seats($id)
    {
        $schedule = Schedule::with(['movie', 'studio', 'studio.seats'])->find($id);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan',
                'data' => null,
            ], 404);
        }

        $bookedSeatIds = TransactionDetail::whereHas('transaction', function ($query) use ($id) {
            $query->where('schedule_id', $id)
                ->where('payment_status', '!=', 'failed');
        })->pluck('seat_id')->toArray();

        $seats = $schedule->studio->seats->map(function ($seat) use ($bookedSeatIds) {
            return [
                'id' => $seat->id,
                'seat_number' => $seat->seat_number,
                'is_booked' => in_array($seat->id, $bookedSeatIds),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data kursi',
            'data' => [
                'schedule' => [
                    'id' => $schedule->id,
                    'show_date' => $schedule->show_date->format('Y-m-d'),
                    'start_time' => $schedule->start_time,
                    'ticket_price' => $schedule->ticket_price,
                ],
                'movie' => [
                    'id' => $schedule->movie->id,
                    'title' => $schedule->movie->title,
                ],
                'studio' => [
                    'id' => $schedule->studio->id,
                    'name' => $schedule->studio->studio_name,
                    'capacity' => $schedule->studio->capacity,
                ],
                'seats' => $seats,
            ],
        ]);
    }
}