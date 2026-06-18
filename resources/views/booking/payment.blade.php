@extends('layouts.app')

@section('title', 'Payment')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-petra bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-petra" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Complete Your Payment</h1>
            <p class="text-gray-500 mt-1">Booking Code: <span class="font-mono font-bold text-petra">{{ $transaction->midtrans_booking_code }}</span></p>
        </div>

        <div class="border-t border-b py-6 mb-6">
            <div class="flex items-center gap-4 mb-4">
                @if($transaction->schedule->movie->poster)
                    <img src="{{ asset('storage/' . $transaction->schedule->movie->poster) }}" alt="{{ $transaction->schedule->movie->title }}" class="w-20 h-28 object-cover rounded-lg">
                @else
                    <div class="w-20 h-28 bg-gray-200 rounded-lg flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M18 4l2 4h-3l-2-4h-2l2 4h-3l-2-4H8l2 4H7L5 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4h-4zM4 18V8h16v10H4zm6-2h2v-4h2v4h2v-6h-6v6z"/></svg>
                    </div>
                @endif
                <div>
                    <h3 class="font-bold text-lg text-gray-800">{{ $transaction->schedule->movie->title }}</h3>
                    <p class="text-sm text-gray-600">{{ $transaction->schedule->studio->studio_name }}</p>
                    <p class="text-sm text-gray-600">{{ $transaction->schedule->show_date->format('d M Y') }} at {{ \Carbon\Carbon::parse($transaction->schedule->start_time)->format('H:i') }}</p>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-semibold text-gray-700 mb-2">Selected Seats</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach($transaction->transactionDetails as $detail)
                        <span class="bg-petra text-white text-sm font-semibold px-3 py-1 rounded-full">{{ $detail->seat->seat_number }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between text-lg font-bold mb-6">
            <span>Total Payment</span>
            <span class="text-petra text-xl">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
        </div>

        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg mb-6">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-yellow-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm text-yellow-800 font-medium">Simulasi Pembayaran</p>
                    <p class="text-sm text-yellow-700 mt-1">Klik tombol di bawah untuk mengkonfirmasi pembayaran. Dalam mode simulasi, transaksi akan langsung dikonfirmasi.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('booking.confirm', $transaction->id) }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-petra hover:bg-petra-dark text-white font-bold py-4 rounded-lg transition-colors text-lg">
                Confirm Payment - Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-4">
            Need help? <a href="#" class="text-petra hover:underline">Contact support</a>
        </p>
    </div>
</div>
@endsection
