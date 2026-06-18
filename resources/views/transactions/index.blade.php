@extends('layouts.app')

@section('title', 'My Tickets')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">My Tickets</h1>

    @forelse($transactions as $transaction)
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-4">
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-lg font-bold text-gray-800">{{ $transaction->schedule->movie->title }}</h3>
                            @if($transaction->payment_status === 'success')
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Paid</span>
                            @elseif($transaction->payment_status === 'pending')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Pending</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Failed</span>
                            @endif
                        </div>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><span class="font-medium">Studio:</span> {{ $transaction->schedule->studio->studio_name }}</p>
                            <p><span class="font-medium">Date:</span> {{ $transaction->schedule->show_date->format('l, d M Y') }}</p>
                            <p><span class="font-medium">Time:</span> {{ \Carbon\Carbon::parse($transaction->schedule->start_time)->format('H:i') }}</p>
                            <p><span class="font-medium">Seats:</span>
                                @foreach($transaction->transactionDetails as $detail)
                                    <span class="bg-petra bg-opacity-10 text-petra-dark text-xs font-semibold px-2 py-0.5 rounded mr-1">{{ $detail->seat->seat_number }}</span>
                                @endforeach
                            </p>
                            <p><span class="font-medium">Booking Code:</span> <span class="font-mono font-bold text-petra">{{ $transaction->midtrans_booking_code }}</span></p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-bold text-petra">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                        @if($transaction->payment_status === 'pending')
                            <a href="{{ route('booking.payment', $transaction->id) }}" class="mt-3 inline-block bg-petra hover:bg-petra-dark text-white font-semibold px-4 py-2 rounded-lg transition-colors text-sm">
                                Complete Payment
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-500 mb-2">No Tickets Yet</h3>
            <p class="text-gray-400 mb-4">You haven't purchased any tickets yet.</p>
            <a href="{{ url('/') }}" class="inline-block bg-petra hover:bg-petra-dark text-white font-semibold px-6 py-2.5 rounded-lg transition-colors">Browse Movies</a>
        </div>
    @endforelse

    {{ $transactions->links() }}
</div>
@endsection
