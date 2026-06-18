<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function selectSchedule(Schedule $schedule)
    {
        $schedule->load(['movie', 'studio']);

        $schedules = Schedule::where('movie_id', $schedule->movie_id)
            ->where('show_date', '>=', now()->toDateString())
            ->with('studio')
            ->orderBy('show_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy('show_date');

        return view('booking.schedule', compact('schedule', 'schedules'));
    }

    public function selectSeats(Schedule $schedule)
    {
        $schedule->load(['movie', 'studio', 'studio.seats']);

        $bookedSeatIds = TransactionDetail::whereHas('transaction', function ($query) use ($schedule) {
            $query->where('schedule_id', $schedule->id)
                ->where('payment_status', '!=', 'failed');
        })->pluck('seat_id')->toArray();

        $seats = $schedule->studio->seats->map(function ($seat) use ($bookedSeatIds) {
            return [
                'id' => $seat->id,
                'seat_number' => $seat->seat_number,
                'is_booked' => in_array($seat->id, $bookedSeatIds),
            ];
        });

        return view('booking.seats', compact('schedule', 'seats'));
    }

    public function checkout(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'seat_ids' => 'required|array|min:1',
            'seat_ids.*' => 'required|exists:seats,id',
        ]);

        $schedule->load('studio');

        $bookedSeatIds = TransactionDetail::whereHas('transaction', function ($query) use ($schedule) {
            $query->where('schedule_id', $schedule->id)
                ->where('payment_status', '!=', 'failed');
        })->pluck('seat_id')->toArray();

        $selectedSeatIds = $validated['seat_ids'];

        $conflictSeats = array_intersect($selectedSeatIds, $bookedSeatIds);
        if (!empty($conflictSeats)) {
            return back()->withErrors(['seat_ids' => 'Some selected seats are already booked.'])->withInput();
        }

        $seatCount = count($selectedSeatIds);
        $totalPrice = $schedule->ticket_price * $seatCount;

        $transaction = DB::transaction(function () use ($schedule, $selectedSeatIds, $totalPrice) {
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'schedule_id' => $schedule->id,
                'total_price' => $totalPrice,
                'payment_status' => 'pending',
            ]);

            foreach ($selectedSeatIds as $seatId) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'seat_id' => $seatId,
                ]);
            }

            return $transaction;
        });

        return redirect()->route('booking.payment', $transaction);
    }

    public function payment(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        if ($transaction->payment_status !== 'pending') {
            return redirect()->route('transactions.index')
                ->with('info', 'This transaction has already been processed.');
        }

        $transaction->load(['schedule.movie', 'schedule.studio', 'transactionDetails.seat']);

        return view('booking.payment', compact('transaction'));
    }

    public function confirmPayment(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        if ($transaction->payment_status !== 'pending') {
            return redirect()->route('transactions.index')
                ->with('info', 'This transaction has already been processed.');
        }

        $transaction->update(['payment_status' => 'success']);

        return redirect()->route('transactions.index')
            ->with('success', 'Payment successful! Your tickets are confirmed.');
    }
}
